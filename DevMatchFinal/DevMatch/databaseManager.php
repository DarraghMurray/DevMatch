<?php
    class databaseManager {

        //database connection
        private $connection = null;

        /*constructor for database object takes database details and creates the connection
        throws an exception if there is a connection error*/
        public function __construct( $dbhost = 'localhost', $dbname = '' , $username ='root' , $password = ''){
            try{
                $this->connection = new mysqli($dbhost, $username, $password, $dbname);
                if( mysqli_connect_errno() ){
                    throw new Exception("Could not connect to database.");   
                }
            }catch(Exception $e){
                throw new Exception($e->getMessage());   
            }			
        
        }	
	
    /*function for executing queries with varying numbers of parameters
    throws an exception if there is an error otherwise returns the result of the query*/
    public function executeStatement( $query , $paramType = false, $params = false ){
        try{
            $stmt = $this->connection->prepare( $query );

            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }
		
            if( $params ){
                $stmt->bind_param($paramType, ...$params);				
            }

            $stmt->execute();
            return $stmt;

        }catch(Exception $e){
            throw New Exception( $e->getMessage() );
        }
    }

    //gets the last inserted id 
    public function getLastInsertID() {
        return mysqli_insert_id($this->connection);
    }

    //starts a transaction
    public function beginTransaction() {
        $this->connection->begin_transaction();
    }

    //commits the transaction queries
    public function commitTransaction() {
        $this->connection->commit();
    }

    //rolls back the transaction queries
    public function rollbackTransaction() {
        $this->connection->rollback();
    }
}

?>