<?php
require_once "DB.php"; 
require_once "./NayQuery.php";

class Nay
{
    public int $ID;

    public string $mesto;


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
        
        if(empty($this->mesto)){
            $editErr = "Pole nemôže byť prázdne!";
        }else{
            $editErr = '';
        }
        $produkty = NayQuery::create()->getAllProdukt();
         foreach($produkty as $produkt){
            if($produkt->mesto === $this->mesto){
                $editErr = "Mesto už existuje.";
                break;
            }
        }
        if(empty($editErr)){
          try {
            NayQuery::create($conn)
                ->saveProdukt($this);
          } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) { // Duplicate key error code
              $editErr = "Mesto už existuje.";
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
        NayQuery::create($conn)->deleteProdukt($this);
        $editErr = "";
      }catch(mysqli_sql_exception $e){
        $editErr = "Chyba: Existujú objednávky používajúce tento produkt. Ostránenenie nie je možné";
      }
      return $editErr;
    }
}
?>