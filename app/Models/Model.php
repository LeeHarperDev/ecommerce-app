<?php

namespace App\Models;

use App\Database\DB;

abstract class Model {
    protected $table;
    protected $attributes;

    /****************************************************************************************************
     *
     * Function: Model.deriveTableFromClass().
     * Purpose: Retrieves the name of the class and returns it in all lower-case.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @return string The lower case form of the class name.
     *
     ***************************************************************************************************/
    private function deriveTableFromClass() {
        $classPath = explode('\\', static::class);

        return strtolower(end($classPath));
    }

    /****************************************************************************************************
     *
     * Function: Model.__construct().
     * Purpose: Constructs a new model instance.
     * Precondition: N/A.
     * Postcondition: A new Model object is initialized.
     *
     ***************************************************************************************************/
    public function __construct() {
        if (is_null($this->table)) {
            $this->table = $this->deriveTableFromClass();
        }
    }

    /****************************************************************************************************
     *
     * Function: Model.getAll().
     * Purpose: Retrieves an array of all instances of the model recorded in the database.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @return array An array of all model instances.
     *
     ***************************************************************************************************/
    public function getAll() {
        return DB::query('SELECT * FROM ' . $this->table);
    }

    /****************************************************************************************************
     *
     * Function: Model.find().
     * Purpose: Finds a model within the database that has a supplied id.
     * Precondition: N/A.
     * Postcondition: N/A.
     *
     * @param int $id The ID being used for the search
     * @return array The model that has the supplied array, or an empty array if none was found.
     *
     ***************************************************************************************************/
    public function find(int $id) {
        $result = DB::query('SELECT * FROM ' . $this->table . ' WHERE id = :id', [':id' => $id]);

        if (count($result) === 0) {
            return array();
        } else {
            return $result[0];
        }
    }
}