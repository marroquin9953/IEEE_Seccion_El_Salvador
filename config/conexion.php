<?php
    session_start();

    class Conectar{
        protected $dbh;

        protected function conexion(){
            try{
                $conectar = $this -> dbh= new PDO("mysql:local=localhost;dbname=stackoverflow;charset=utf8","root","");
                return $conectar;
            }catch(Exception $e){
                print "Error BD:" . $e->getMessage()."<br>";
                die();
            }
        }

        public function set_names(){
            return $this->dbh->query("SET NAMES 'utf8'");
        }

        public static function ruta(){
            return "http://localhost:90/PERSONAL_StackOverFlow/";
        }
    }
?>