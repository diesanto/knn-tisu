<?php
require_once('distance.php');

class Knn extends Distance{

    protected $x = array();
    protected $y = array();

    protected $distances = array();

    public function __construct(array $x, array $y, $k = 1, $distanceMethode = 'euclidean')
    {
        $num     = count($x);

        switch ($distanceMethode) {
            case 'euclidean':
                for ($i = 0; $i < $num; $i++) $this->distances['D'.$i] = $this->euclidean($x[$i], $y);        
                break;
            case 'squaredEuclidean':
                for ($i = 0; $i < $num; $i++) $this->distances['D'.$i] = $this->squaredEuclidean($x[$i], $y);
                break;
            case 'manhattan':
                for ($i = 0; $i < $num; $i++) $this->distances['D'.$i] = $this->manhattan($x[$i], $y);
                break;
            case 'cosinus':
                for ($i = 0; $i < $num; $i++) $this->distances['D'.$i] = 1 - $this->cosinus($x[$i], $y);
                break;
        }

        asort($this->distances); //Sort Dari kecil ke besar 

        $this->distances = array_slice($this->distances, 0, $k); //ambil K terbaik

    }

    public function get_distance(){
        if(count($this->distances) > 1){
            $distance = array();
            asort($this->distances);

            foreach ($this->distances as $key => $value) $distance[] = $value;
        }
        else{
            $distance = min($this->distances);
        }        
        return $distance;
    }

    public function get_knn(){
        $rank = array();
        foreach ($this->distances as $key => $value) {
            $key = substr($key, 1); //Hilangkan D didepan
            array_push($rank, $key);
        }
        return $rank;
    }

    public function get_nn(){
        $rank = min($this->distances);
        $rank = array_search($rank, $this->distances);
        return substr($rank, 1);
    }   
}