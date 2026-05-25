<?php
require_once "DB.php"; 
require_once "./MobilyQuery.php";

class Mobily
{
    public int $ID;

    public string $nazov;
    public float $cena;
    public string $model;


    /** @var bool ci uz dany objekt bol odstraneny z DB */
    public bool $isDeleted = false;

    /**
     * @return bool ci ma produkt svoje id
     */
    public function hasId() : bool
    {
        return (bool)$this->ID;
    }
    public function save(mysqli $conn = null):string
    {
        
        if(empty($this->nazov) || empty($this ->cena)){
            $editErr = "Pole/Polia nemôžu byť prázdne!";
        }else{
            $editErr = '';
        }
        $produkty = MobilyQuery::create()->getAllProdukt();
         foreach($produkty as $produkt){
            if($produkt->nazov === $this->nazov && $produkt->cena === $this->cena && $produkt->model === $this->model){
                $editErr = "Názov už existuje.";
                break;
            }
        }
        if(empty($editErr)){
          try {
            MobilyQuery::create($conn)
                ->saveProdukt($this);
          } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) { // Duplicate key error code
              $editErr = "Názov už existuje.";
            } else {
              $editErr = "Chyba: " . $e->getMessage();
            }
          }
        }
        return $editErr;
    }
    /**
     * odstrani zaznam z DB a nastavi prizna isDeleted na true
     * @param mysqli $conn
     * @return string
     */
    public function delete(mysqli $conn = null):string
    {
      try{
        MobilyQuery::create($conn)->deleteProdukt($this);
        $editErr = "";
      }catch(mysqli_sql_exception $e){
        $editErr = "Chyba: Existujú objednávky používajúce tento produkt. Ostránenenie nie je možné";
      }
      return $editErr;
    }
}
?>