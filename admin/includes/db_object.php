<?php

class Db_object {

    protected static $db_table = "users";

    public static function find_all() {
        return static::find_by_query("SELECT * FROM " . static::$db_table . " ");
    }

    public static function find_by_id($id) {
        $the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE id = $id LIMIT 1");
        
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public static function find_by_query($sql) {
        global $database; // reference back to database.php's $database

        $result_set = $database->query($sql); // connect to the database
        $the_object_array = array(); // Create an array of objects

        while($row = mysqli_fetch_array($result_set)) { // While loop to fetch database table into $row
            $the_object_array[] = static::instantation($row); // pass $row into Instantation

        }
        return $the_object_array;
    }

    public static function instantation($the_record) {
        $calling_class = get_called_class();
        $the_object = new $calling_class; // instantiates the object

        foreach($the_record as $the_attribute => $value) { // loops through the table
            if($the_object->has_the_attribute($the_attribute)) { // makes sure the table has an attribute
                $the_object->$the_attribute = $value; //assign the object property a value (i.e. username, password, id)
            } 
        }

        return $the_object;
    }

    protected function properties() {
        $properties = array();

        foreach(static::$db_table_fields as $db_field) {
            if(property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }

        return $properties;
    }

    protected function clean_properties() {
        global $database;

        $clean_properties = array();

        foreach($this->properties() as $key => $value) {
            $clean_properties[$key] = $database->escape_string($value);
        }

        return $clean_properties;
    }

    private function has_the_attribute($the_attribute) {
        $object_properties = get_object_vars($this); // picks up the attributes from all of our user class ($this)

        return array_key_exists($the_attribute, $object_properties); // find out if this attribute is in the object properties array
    }

    public function save() {
        return isset($this->id) ? $this->update() : $this->create();
    }

    // Create Method
    public function create() {
        global $database;

        $properties = $this->clean_properties();

        $sql = "INSERT INTO " .static::$db_table . "(" . implode(",", array_keys($properties)) . ")";
        $sql .= "VALUES ('" . implode("','", array_values($properties)) . "')";

        if ($database->query($sql)) {
            $this->id = $database->the_insert_id();
            return true;
        } else {
            return false;
        }
    } 

    // Update Method
    public function update() {
        global $database;

        $properties = $this->clean_properties();

        $properties_pairs = array();

        foreach($properties as $key => $value) {
            $properties_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " .static::$db_table . " SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE id = "   . $database->escape_string($this->id);

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    } 

    // Delete Method
    public function delete() {
        global $database;

        $sql = "DELETE FROM " .static::$db_table . " ";
        $sql .= " WHERE id = "   . $database->escape_string($this->id);
        $sql .= " LIMIT 1";

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;

    } 

    public static function count_all() {
        global $database;
        $sql = "SELECT COUNT(*) FROM " . static::$db_table;
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);

        return array_shift($row);
    }
}



?>