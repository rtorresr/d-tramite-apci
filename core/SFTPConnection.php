<?php
/**
 * Created by PhpStorm.
 * User: anthonywainer
 * Date: 15/11/2018
 * Time: 15:09
 */



class SFTPConnection
{
    private $connection;
    private $sftp;

    public function __construct($host, $port)
    {
        $this->connection = @ssh2_connect($host, $port);
        if (! $this->connection)
            throw new Exception("Could not connect to $host on port $port.");
    }

    public function login($username, $password)
    {
        if (! @ssh2_auth_password($this->connection, $username, $password))
            throw new Exception("Could not authenticate with username $username " .
                "and password $password.");

        $this->sftp = @ssh2_sftp($this->connection);
        if (! $this->sftp)
            throw new Exception("Could not initialize SFTP subsystem.");
    }

    public function createFolder($files,$path)
    {
        $sftp = $this->sftp;
        foreach  ($files as $f ){
            $path .='/'.$f;
            if (!file_exists('ssh2.sftp://' . $sftp . '/' . $path)) {
                ssh2_sftp_mkdir($sftp, $path, 0777, true);
            }
        }
        return $path;
    }


    public function uploadFile($local_file, $remote_file) {
        $sftp = $this->sftp;
        $stream = fopen("ssh2.sftp://$sftp$remote_file", 'w');
        $file = file_get_contents($local_file);
        fwrite($stream, $file);
        fclose($stream);
        ssh2_disconnect ( $sftp );
        return "guardado correctamente";
    }
}

