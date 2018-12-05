<?php
class DB {
    /*
    Singleton Method
    The purpose of the Singleton class is to control object creation, limiting the number of objects to only one. 
    The singleton allows only one entry point to create the new instance of the class.
    */
    private static $_instance = null;
    private $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_count = 0,
            $_options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

/*
constructor function that will connect to our DB
it's run when the class is instanciated
*/
    private function __construct(){
        try {
            $this->_pdo = new PDO( 'mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'), $this->_options);
            /*
            new PDO arguments
            1) string: defines which DB handler one wants to connect to
            2) username: 
            3) password:
            */
        }
        catch (PDOException $e) {
            die("Connection Failed: " . $e->getMessage());
        }
    }

    /*
    We need to instantiate our object
    By instantiating our object, we need to connect to our DB
    It's great because if we're calling on the db twice on one page, 
    we won't have to reconnect for the new instance.
    :: access for static functions
    -> access for non-static, requires an (instanace/object/live variable)
    */
    public static function getInstance(){
        if (!isset(self::$_instance)){
            self::$_instance = new DB();
        }
      //  var_dump(self::$_instance);
        return self ::$_instance;

    }
    public function getConnection()
    {
        if ($this->_pdo == null)
            $this->_pdo = new PDO( 'mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'), $this->_options);
        return $this->_pdo;
    }
    public function query ($sql, $params = array()) {
        $this->_error = false;
        if ($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if (count($params)){
                foreach($params as $param){
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }
            if ($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
          }
          return $this;
        }

        public function action($action, $table, $where = array()){
            if(count($where) === 3){
                $operators = array('=', '>', '<', '>=', '<=', 'LIKE');
                $field      = $where[0];
                $operator   = $where[1];
                $value      = $where[2];

                if(in_array($operator, $operators)){
                    $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                    if (!$this->query($sql, array($value))->error()){
                        return $this;
                    }
                }
            }
            return false;
        }

        public function get($table, $where){
            return $this->action('SELECT *', $table, $where);
        }

        public function delete($table, $where) {
            return $this->action('DELETE', $table, $where);
        }

        public function insert($table, $fields = array()){
            if(count($fields)){
                $keys = array_keys($fields);
                $values = '';
                $x = 1;

                foreach($fields as $field){
                    $values .= '?';
                    if($x < count($fields)){
                        $values .= ', ';
                    }
                    $x++;
                }
                $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys). "`) VALUES ({$values})";

                if (!$this->query($sql, $fields)->error()) {
                    return true;
               } else
                    //throw new \PDOException($e->getMessage(), (int)$e->getCode());
                        throw new Exception('There was a problem creating an account.' . print_r($this->_pdo->errorInfo()));

            }
        //    *** you edited the table as opposed to fixed at users ***
            return false;

            /*
             * try {
                 self::$pdo = new PDO($dsn, self::$user, self::$pass, $options);
            } catch (\PDOException $e) {
                 throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
             */
        }

        public function update($table, $id, $fields){
            $set = '';
            $x = 1;

            foreach($fields as $name => $value){
                $set .= "{$name} = ?";
                if($x < count($fields)){
                    $set .= ', ';
                }
                $x++;
            }

            $sql = "UPDATE {$table} SET {$set} WHERE id = ($id)";

            if(!$this->query($sql, $fields)->error()){
                  return true;
            }
            return false;
        }

        public function results(){
            return $this->_results;
        }

        public function first(){
            return $this->results()[0];
        }

        public function error (){
            return $this->_error;
        }

        public function count(){
            return $this->_count;
        }
    }
?>
