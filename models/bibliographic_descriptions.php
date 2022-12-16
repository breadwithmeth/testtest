<?php

class bibliographic_description{
    private $db;
    function __construct($db)
    {
        $this->db = $db;
    }
    function add(){
        
        
        
    } 

    function get($data, $library_id){

        $type_values = [];
        $query = "SELECT `bd`.`id`, `bd`.`title` `title`, `bd`.`number_of_pages`, `bd`.`author_sign`,
         (SELECT GROUP_CONCAT(a.name SEPARATOR ', ') 
         FROM book_author `ba` LEFT JOIN authors `a` ON `a`.`id` = `ba`.`author_id` 
         WHERE book_id = `bd`.`id`) `authors`, 
         (SELECT GROUP_CONCAT(lb.inventory_number SEPARATOR ', ') 
         FROM library_books `lb` WHERE library_id = ? AND book_id = `bd`.`id`) `inventory_numbers`, 
        --  (SELECT GROUP_CONCAT(CONCAT(`l`.name) SEPARATOR ', ') 
        --  FROM library_books `lb` LEFT JOIN `libraries` `l` ON `lb`.`library_id` = `l`.id
        --  WHERE  book_id = `bd`.`id`) `libraries`,
        (SELECT GROUP_CONCAT(CONCAT(libraries.name, '(', temp.amount, ')') SEPARATOR '&') FROM (SELECT COUNT(library_id) amount, library_id, book_id FROM `library_books` 
GROUP BY library_id,book_id) temp LEFT JOIN `libraries` ON libraries.id = temp.library_id WHERE temp.book_id = bd.id) `libraries`, 
         `bd`.`publication_year`, `bof`.`name_ru` `by_branches_of_knowledge`, `bd`.`part_number`, `bd`.`part_name`, `bd`.`ISBN`, `p`.`name` publisher, `bd`.`book_circulation`, `bd`.`series`, `pop`.`name_ru` place_of_publication, `bd`.`price`
         FROM `books_description` `bd`
         LEFT JOIN branches_of_knowledge `bof` ON `bof`.`id` = `bd`.`by_branches_of_knowledge`
         LEFT JOIN publishers `p` ON `p`.`id` = `bd`.`publisher`
         LEFT JOIN places_of_publication `pop` ON `pop`.`id` = `bd`.`place_of_publication`
          ";
            try {
                $limit = 30;
            $offset = ($_GET['page']-1) * $limit;
            $books = [];
            if (isset($data['filter'])) {
                if (isset($data['filter']['search'])) {
                    switch ($data['filter']['search']['search_column']) {
                        case 'by_title':
                            $query .= " WHERE `bd`.`title` LIKE ?";
                            $keyword = $data['filter']['search']['keyword'] . "%";
                            break;
                        case 'by_invent_number':
                            $query .= "
                            WHERE `bd`.`id` in(SELECT book_id FROM library_books WHERE inventory_number = ?)";
                            $keyword = $data['filter']['search']['keyword'];
                            break;
                        case 'by_author':
                            $query .= "
                            WHERE `bd`.`id` in(SELECT book_author.book_id book_id
                            FROM book_author 
                            LEFT JOIN authors on authors.id = book_author.author_id
                            WHERE authors.name LIKE ?)";
                            $keyword = $data['filter']['search']['keyword'] . "%";
                            break;
                        default:
                            # code...
                            break;
                    }
                }
                if (isset($data['filter']['sort_column'])) {
                    switch ($data['filter']['sort_column']) {
                        case 'by_title':
                            $query .= " ORDER BY `bd`.`title` ";
                            break;
                        case 'by_year':
                            $query .= " ORDER BY `bd`.`publication_year` ";
                            break;  
                            default:
                                header("HTTP/1.1 400 sort column was not specified");
                            return false;
                    }
                    switch ($data['filter']['sort_direction']) {
                        case 'desc':
                            $query .= " DESC";
                            break;
                        case 'asc':
                            $query .= " ASC";
                            break;
                        default:
                            # code...
                            break;
                    }
                }
                
                $query .= " LIMIT ? OFFSET ?";
                $stmt = $this->db->prepare($query); 
                // call_user_func_array(array($stmt, bind_param), array("three", "four"));
                if (isset($data['filter']['search'])) {
                    $stmt->bind_param("ssii", $library_id, $keyword, $limit, $offset);
                }else{
                
                    $stmt->bind_param("sii", $library_id, $limit, $offset);
                }

            }
            // $stmt = $this->db->prepare("SELECT `bd`.`id`, `bd`.`title`, `bd`.`number_of_pages`, `bd`.`author_sign`, (SELECT GROUP_CONCAT(a.name SEPARATOR ', ') FROM book_author `ba` LEFT JOIN authors `a` ON `a`.`id` = `ba`.`author_id` WHERE book_id = `bd`.`id`) `authors` FROM `books_description` `bd` 
            // LIMIT ? OFFSET ?");
            // $stmt->bind_param("ii", $limit, $offset);
            $stmt->execute();
            
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                array_push($books, $row);
            }
            $stmt = $this->db->prepare("SELECT COUNT(*)/30 total_pages FROM `books_description`");
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $resultArray = [];
            $resultArray['books'] = $books;
            $resultArray['total_pages'] = $row['total_pages'];
            return $resultArray;
            } catch (\Throwable $th) {
                echo $th;
            }
            

    }
}

