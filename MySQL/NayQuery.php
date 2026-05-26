<?php 

class NayQuery
{
    // atribut instancie triedy
    private mysqli $conn;

    public function __construct(mysqli $conn = null)
    {
        if ($conn == null) {
            $conn = DefaultConnection::getDefaultConnection();
        }

        $this->conn = $conn;
    }

    /**
     * @param mysqli $conn
     * @return self
     */
    public static function create(mysqli $conn = null): self
    {
        return new self($conn);
    }

    private function updateProdukt(Nay $produkt)
    {
        $sql = "UPDATE nay SET mesto='{$produkt->mesto}' WHERE id_nay={$produkt->ID}";
        
        mysqli_query($this->conn, $sql);
    }

    private function insertProdukt(Nay $produkt)
    {
        // vloz novy zaznam
        $sql = "INSERT INTO nay (`mesto`) VALUES ('{$produkt->mesto}')";

        if ($this->conn->query($sql) !== true) {
            throw new InvalidArgumentException("Nepodarilo sa vlozit novy produkt");
        }

        // do produkt vlozime nove id 
        $produkt->ID = $this->conn->insert_id;
    }
    public function saveProdukt(Nay $produkt)
    {
            $this->insertProdukt($produkt);
            return;            
        // updatni existujuci zaznam
        $this->updateProdukt($produkt);
    }

    /**
     * @return Nay[]
     */
    public function getAllProdukt() : array
    {
        $sql = 'SELECT * FROM nay';
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            return [];
        }

        $produkty = [];
        while ($row = $result->fetch_object('Nay')) {
            $produkty[] = $row;
        }

        return $produkty;

    }

    public function getProduktById(int $id_produktu):Nay
    {
        $sql = "SELECT * FROM nay where ID = $id_produktu ";
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            throw new InvalidArgumentException("Produkt s id '$id_produktu' sa nenasiel");
        }

        $produktyRaw = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if (count($produktyRaw) == 0) {
            throw new InvalidArgumentException("Produkt s id '$id_produktu' sa nenasiel");
        }

        $produktRaw = $produktyRaw[0];
        $produkt = new Nay();

        $produkt->ID = $produktRaw['ID'];
        $produkt->mesto = $produktRaw['mesto'];

        return $produkt;
    }

    public function createProdukt(int $id_produktu=0):Nay
    {
        $produkt = null;
        try{
            $produkt = $this->getProduktById($id_produktu);
        }catch(InvalidArgumentException $e){
            $produkt = new Nay();
            $produkt->ID = $id_produktu;
        }

        return $produkt;
    }

    public function deleteProdukt(Nay $produkt, $conn):void
    {
        $produkt = $this->getProduktById($produkt->ID);

        $sql = "DELETE FROM nay WHERE ID={$produkt->ID}";

        if ($this->conn->query($sql) !== true) {
            throw new InvalidArgumentException("Nepodarilo sa vymazat kategoriu");
        }

        $produkt->isDeleted = true;
    }
}