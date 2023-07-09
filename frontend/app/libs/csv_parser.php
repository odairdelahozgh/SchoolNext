<?php
/**
 * CSV_parser
 * 
 * @package   
 * @author Dave's Simple Project
 * @copyright MESMERiZE
 * @version 2012
 * @access public
 */
class CsvParser
{
    private $source;
    private $array;
    private $length;
    private $delimiter;
    private $class;
    private $padding;
    private $border;
    private $id;
    private $width;

    /**
     * CSV_parser::__construct()
     * 
     * @param mixed $source
     * @param integer $length
     * @param string $delimiter
     * @return
     */
    public function __construct($source, $length = 8000, $delimiter = ',')
    {
        try
        {
            // Lets try to open the file and check if its readable else throw an error.
            if (!isset($source) || !is_readable($source))
            {
                throw new Exception(message: 'File Not Found!');
                return false;
            } else
            {
                //set the source file
                $this->source = $source;
                $this->length = $length;
                $this->delimiter = $delimiter;
                return true;
            }
        }
        catch (exception $e)
        {
            // Send an error message :)
            echo $e->getMessage();
        }
        //parent::__construct();
    }
    /**
     * CSV_parser::toArray()
     * 
     * @return
     */
    public function toArray()
    {
        $handler = fopen($this->source, 'r'); // 1. First open the source file
        // 2. Turn the CSV to array
        while (($data = fgetcsv($handler, $this->length, $this->delimiter)) !== false) {
            $a[] = $data;
        }
        
        $h = $a[0]; // 3. Get the first index to be used as the key
        foreach ($h as $k => $v) { // 4. Lets remove the $h variable's empty values
            if ($v != '') {
              $headers[$k] = $v;
            }
        }
        $a = array_slice($a, 1); // 4. Remove the first index and leave the others to be used as the value
        $array = array(); // 5. Make an empty array
        
        foreach ($a as $k => $v) { // 6. Lets loop the values
            $i = 0;
            // then loop the headers then for each headers lets get the values
            // from variable $a based on how many the headers are. So we increment.
            foreach ($headers as $key => $value)
            {
                $array[$k][$value] = $v[$i];
                $i++;
            }
        }
        return $array;
        fclose($handler);
    }
    /**
     * CSV_parser::toTable()
     * 
     * @param string $width
     * @param integer $border
     * @param integer $spacing
     * @param integer $padding
     * @param string $class
     * @param mixed $id
     * @return
     */
    public function toTable($width = '100%', $border = 1, $spacing = 0, $padding = 5,
        $class = 'mytable', $id = null)
    {
        $this->width = $width;
        $this->class = $class;
        $this->spacing = $spacing;
        $this->padding = $padding;
        $this->border = $border;
        $this->id = $id;

        $table = '<table width="' . $this->width . '" class="' . $this->class .
            '" cellspacing="' . $this->spacing . '" cellpadding="' . $this->padding .
            '" id="' . $this->id . '" border="' . $this->border . '">';
        // 1. Lets create some table headers
        $table .= '<thead><tr>';
        foreach ($this->toArray() as $key => $value)
        {
            $headers = $value;
        }
        $headers = array_keys($headers);
        foreach ($headers as $th)
        {
            $table .= '<th>' . $th . '</th>';
        }
        $table .= '</tr></thead>';
        // Lets create the table body
        $table .= '<tbody>';
        foreach ($this->toArray() as $key => $value)
        {
            $table .= '<tr>';
            foreach ($value as $val)
            {
                $table .= '<td>' . $val . '</td>';
            }
            $table .= '<tr>';

        }
        $table .= '</tbody>';
        $table .= '</table>';
        return $table;

    }
    /**
     * CSV_parser::toJSON()
     * 
     * @return
     */
    public function toJSON()
    {
        return json_encode($this->toArray());
    }
    public function toMYSQL($table_name = 'table_name')
    {
        $str = '';
        $the_array = $this->toArray();
        foreach($the_array as $array)
        {
            $k = implode(',',array_keys($array));
            $v = "'".implode("','",array_values($array))."'";
            $str .= "INSERT INTO $table_name($k) VALUES($v)\n";
        }
        return $str;
    }

}
// $data = new CsvParser('C:\wamp\www/sample.csv');
// echo '<code>';
// echo $data->toJSON();
// echo '</code>';
// echo $data->toTable();
// echo '<pre>';
//     echo $data->toMYSQL('',TRUE);
// echo '</pre>';
// echo '<pre>';
//     print_r($data->toArray());
// echo '</pre>';
?>