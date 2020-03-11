<?php

class Distance
{
    /**
    * Euclidean distance
    * d(a, b) = sqrt( summation{i=1,n}((b[i] - a[i]) ^ 2) )
    *
    * @param array $a
    * @param array $b
    * @return boolean
    */
    public function euclidean(array $a, array $b) {
        if (($n = count($a)) !== count($b)) return false;

        $sum = 0;
        for ($i = 0; $i < $n; $i++){  
             $sum += pow($b[$i] - $a[$i], 2);
        }
        return sqrt($sum);
    }

    public function squaredEuclidean(array $a, array $b) {
        if (($n = count($a)) !== count($b)) return false;

        $sum = 0;
        for ($i = 0; $i < $n; $i++){      
            $sum += pow($b[$i] - $a[$i], 2);
        }            

        return $sum;
    }

    /**
    * Manhattan distance
    * d(a, b) = summation{i=1,n}(abs(b[i] - a[i]))
    *
    * @param array $a
    * @param array $b
    * @return boolean
    */
    public function manhattan(array $a, array $b) {
        if (($n = count($a)) !== count($b)) return false;
        $sum = 0;
        for ($i = 0; $i < $n; $i++)
            $sum += abs($b[$i] - $a[$i]);
        return $sum;
    }

    /**
     * Euclidean norm
     * ||x|| = sqrt(x・x) // ・ is a dot product
     *
     * @param array $vector
     * @return mixed
     */
    protected function norm(array $vector) {
        return sqrt($this->dotProduct($vector, $vector));
    }

    /**
     * Dot product
     * a・b = summation{i=1,n}(a[i] * b[i])
     *
     * @param array $a
     * @param array $b
     * @return mixed
     */
    protected function dotProduct(array $a, array $b) {
        $dotProduct = 0;
        // to speed up the process, use keys with non-empty values
        $keysA = array_keys(array_filter($a));
        $keysB = array_keys(array_filter($b));
        $uniqueKeys = array_unique(array_merge($keysA, $keysB));
        foreach ($uniqueKeys as $key) {
            if (!empty($a[$key]) && !empty($b[$key]))
                $dotProduct += ($a[$key] * $b[$key]);
        }
        return $dotProduct;
    }

    /**
     * Cosine similarity for non-normalised vectors
     * sim(a, b) = (a・b) / (||a|| * ||b||)
     *
     * @param array $a
     * @param array $b
     * @return mixed
     */
    public function cosinus(array $a, array $b) {
        $normA = $this->norm($a);
        $normB = $this->norm($b);
        return (($normA * $normB) != 0)
               ? $this->dotProduct($a, $b) / ($normA * $normB)
               : 0;
    }
}
