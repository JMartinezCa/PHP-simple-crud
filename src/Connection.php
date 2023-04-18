<?php 

class Connection{
    Protected Static $db = null;
    protected String $host;
    protected String $user;
    protected String $pass;
    protected String $name;
    protected String $charset;

    public function __construct(){
        $this->host = 'localhost';
        $this->user = 'root';
        $this->pass = '';
        $this->name = 'crud';
        $this->charset = 'utf8';

        $this->connection();
    }

    /**
     * @return Void
     */
    private function connection():Void{
        try {
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false
            ];

            $dsn = sprintf('mysql:localhost=%s;dbname=%s;charset=%s', $this->host, $this->name, $this->charset);

            static::$db = new \PDO($dsn, $this->user, $this->pass, $options);

        } catch (\PDOException $error) {
            $this->closeConnection();
            die(json_encode(['result' => false, 'message' => $error->getMessage() ]));
        }
    }

    /**
     * @return Object|null
     */
    public function DB():?Object{
        return static::$db;
    }

    /**
     * @return Void
     */
    public function closeConnection():Void{
        static::$db = null;
    }

}