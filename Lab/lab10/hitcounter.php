<?php

class HitCounter
{
    public $hit;
    public $id;


    // Contructor
    public function __construct($hit_value, $id_value)
    {
        $this->hit = $hit_value;
        $this->id = $id_value;
    }

    // Connection
    public function connection($host, $user, $pwd, $sql_db)
    {
        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
        return $conn;
    }

    // Get and display hits on the page
    public function getHits($conn, $table)
    {

        $query = "SELECT hits, id FROM $table";

        $data_retrive = @mysqli_query($conn, $query);

        if (!$data_retrive) {
            $err = @mysqli_error($conn) . @mysqli_errno($conn);
            die("<p>$err</p>");
        } else {
            $row = mysqli_fetch_row($data_retrive);
            if ($row >= 0) {
                $this->hit = $row[0];
            }
        }
    }
    // Get and display hits on the page
    public function setHits($conn, $table)
    {
        $query = "SELECT hits, id FROM $table";

        $data_retrive = @mysqli_query($conn, $query);

        if (!$data_retrive) {
            $err = @mysqli_error($conn) . @mysqli_errno($conn);
            return "<p>$err</p>";
        } else {
            $row = mysqli_fetch_row($data_retrive);
            if ($row >= 0) {
                $hit = $row[0];
                $id = $row[1];
                // increment 1 to hit
                $hit++;
                // re-assign the datavalue
                $this->hit = $hit;
                $this->id = $id;
                $update_query = "UPDATE $table SET hits = '$hit' WHERE id = '$id'";
                @mysqli_query($conn, $update_query);
            }
        }
    }


    // Close connection
    public function closeConnection($conn)
    {
        // true if ok, false for fail
        return @mysqli_close($conn);
    }


    // Reset counter
    public function startOver()
    {
        $this->hit = 0;
    }



}
