<?php
class PGSQL_spdo extends PDO
{
	//DOMINIO GRATIS: http://sysventasperu.net23.net/home.php
	
     private static $instance = null;
    protected $host='mysql4.000webhost.com';
    protected $port='3306';
    protected $dbname='a4713090_siscomp';
    // protected $user='cofisoco_siscomp';
    protected $user='a4713090_root';
    // protected $password='admin123*';
    protected $password='sistemas123';
    protected static $exec = "call";

    public function __construct()
    {
       
        $dns='mysql:dbname='.$this->dbname.';host='.$this->host.';port='.$this->port;
        $user = $this->user;
        $pass = $this->password;
        parent::__construct($dns,$user,$pass);
    }
    public static function getExec()
    {
        return self::$exec;
    }
    public static function singleton()
	{
             if( self::$instance == null )
                {
                    self::$instance = new self();
                }
             return self::$instance;
	}
	public  function db()
	{
		return $this->dbname;
	}
}
?>
