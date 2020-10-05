<?php

/**
 * Description of Operation
 *
 */
class Operation {

    // database connection and table name
    private $conn;
    private $table_name = "bqeops";
    // paging properties
    public $limit;
    public $offset;
    // object properties
    public $id;
    public $account;
    public $date;
    public $amount;
    public $description;
    public $tags;
    // search properties
    public $amount_more_than;
	 public $amount_less_than;
    // logs
    public $log;

    // constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // list operations
    function list() {
        // query to select all
        $query = "SELECT d.id, d.account, d.date, d.amount, d.description, d.tags
            FROM
                " . $this->table_name . " d
            ORDER BY
                d.id";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }
    
    // get operation
    function get() {
        // query to select item with an id
        $query = "SELECT d.id, d.account, d.date, d.amount, d.description, d.tags
            FROM
                " . $this->table_name . " d
            WHERE id=:id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind values
        $stmt->bindParam(":id", $this->id);        
        
        // execute query
        $stmt->execute();
        return $stmt;
    }
    
    // search operations
    function search() {
        // query to select items with search criteria
        $query = "SELECT d.id, d.account, d.date, d.amount, d.description, d.tags
            FROM
                " . $this->table_name . " d";
                
        $query = $query." WHERE 1=1 ";
                
		  if(!empty($this->account)) {   
		  		$query = $query." AND account=:account ";   
	     }
	     if(!empty($this->date)) {   
		  		$query = $query." AND date=:date ";   
	     }     
	     if(!empty($this->date_before)) {   
		  		$query = $query." AND date<:date_before ";   
	     }   
	     if(!empty($this->date_after)) {   
		  		$query = $query." AND date>:date_after ";   
	     }   	     	     
	     if(!empty($this->amount)) {   
		  		$query = $query." AND amount=:amount ";   
	     }     
  	     if(!empty($this->amount_more_than)) {   
		  		$query = $query." AND amount>=:amount_more_than ";   
	     }   
  	     if(!empty($this->amount_less_than)) {   
		  		$query = $query." AND amount<=:amount_less_than ";   
	     } 	     
	     if(!empty($this->description)) {   
		  		$query = $query." AND description=:description ";   
	     }     
	     if(!empty($this->description_contains)) {   
		  		$query = $query." AND description LIKE '%".$this->description_contains."%' ";   
	     }    	     
	     if(!empty($this->tags)) {   
		  		$query = $query." AND tags=:tags ";   
	     }
	     if(!empty($this->tags_contains)) {   
		  		$query = $query." AND tags LIKE '%".$this->tags_contains."%' "; 
	     }  	                       

        $query = $query." ORDER BY d.date ";    
        	  
        if(isset($this->limit)) {
        	   if(isset($this->offset)) {
					$query = $query." LIMIT ".$this->offset.",".$this->limit." ";
        	   } else {
					$query = $query." LIMIT ".$this->limit." ";
        	   }				      
        }

        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind values
        if(!empty($this->account)) $stmt->bindParam(":account", $this->account);        
        if(!empty($this->date)) $stmt->bindParam(":date", $this->date);  
        if(!empty($this->date_before)) $stmt->bindParam(":date_before", $this->date_before);  
        if(!empty($this->date_after)) $stmt->bindParam(":date_after", $this->date_after);                  
        if(!empty($this->amount)) $stmt->bindParam(":amount", $this->amount);  
		  if(!empty($this->amount_more_than)) $stmt->bindParam(":amount_more_than", $this->amount_more_than);  
		  if(!empty($this->amount_less_than)) $stmt->bindParam(":amount_less_than", $this->amount_less_than);
        if(!empty($this->description)) $stmt->bindParam(":description", $this->description);       
        if(!empty($this->tags)) $stmt->bindParam(":tags", $this->tags);   
          
        // execute query
        $stmt->execute();
        $this->log = $query;
		  return $stmt;
    }

    // create operation
    function create() {
        // query to insert record
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                account=:account,
                date=:date,
                amount=:amount,
                description=:description,
                tags=:tags";
        // prepare query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->account = htmlspecialchars(strip_tags($this->account));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->amount = htmlspecialchars(strip_tags($this->amount));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->tags = htmlspecialchars(strip_tags($this->tags));

        // bind values
        $stmt->bindParam(":account", $this->account);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":tags", $this->tags);

        // execute query
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return -1;
        }
    }
    
    // update the operation
    function update() {
        // update query
        $query = "UPDATE
                " . $this->table_name . "
            SET
                account = :account,
                date = :date,
                amount = :amount,
                description = :description,
                tags = :tags
            WHERE
                id = :id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->account = htmlspecialchars(strip_tags($this->account));
		  $this->date = htmlspecialchars(strip_tags($this->date));
		  $this->amount = htmlspecialchars(strip_tags($this->amount));
		  $this->description = htmlspecialchars(strip_tags($this->description));
		  $this->tags = htmlspecialchars(strip_tags($this->tags));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind new values
        $stmt->bindParam(':account', $this->account);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':amount', $this->amount);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':tags', $this->tags);
        $stmt->bindParam(':id', $this->id);

        // execute the query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    // delete the operation
    function delete() {
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->id);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}

?>
