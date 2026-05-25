<?php 

class MobilyQuery
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

    private function updateProdukt(Mobily $produkt)
    {
        $sql = "UPDATE mobily SET nazov='{$produkt->nazov}', cena='{$produkt->cena}', model='{$produkt->model}' WHERE id_mobily={$produkt->ID}";
        
        mysqli_query($this->conn, $sql);
    }

    private function insertProdukt(Mobily $produkt)
    {
        // vloz novy zaznam
        $sql = "INSERT INTO mobily (`nazov`, `cena`, `model`) VALUES ('{$produkt->nazov}','{$produkt->cena}','{$produkt->model}')";

        if ($this->conn->query($sql) !== true) {
            throw new InvalidArgumentException("Nepodarilo sa vlozit novy produkt");
        }

        // do produkt vlozime nove id 
        $produkt->ID = $this->conn->insert_id;
    }
    public function saveProdukt(Mobily $produkt)
    {
            $this->insertProdukt($produkt);
            return;            
        // updatni existujuci zaznam
        $this->updateProdukt($produkt);
    }

    /**
     * @return Mobily[]
     */
    public function getAllProdukt() : array
    {
        $sql = 'SELECT * FROM mobily';
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            return [];
        }

        $produkty = [];
        while ($row = $result->fetch_object('Mobily')) {
            $produkty[] = $row;
        }

        return $produkty;

    }

    public function getProduktById(int $id_produktu):Mobily
    {
        $sql = "SELECT * FROM mobily where ID = $id_produktu ";
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            throw new InvalidArgumentException("Produkt s id '$id_produktu' sa nenasiel");
        }

        $produktyRaw = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if (count($produktyRaw) == 0) {
            throw new InvalidArgumentException("Produkt s id '$id_produktu' sa nenasiel");
        }

        $produktRaw = $produktyRaw[0];
        $produkt = new Mobily();

        $produkt->ID = $produktRaw['ID'];
        $produkt->nazov = $produktRaw['nazov'];
        $produkt->cena = $produktRaw['cena'];
        $produkt->model = $produktRaw['model'];

        return $produkt;
    }

    public function createProdukt(int $id_produktu=0):Mobily
    {
        $produkt = null;
        try{
            $produkt = $this->getProduktById($id_produktu);
        }catch(InvalidArgumentException $e){
            $produkt = new Mobily();
            $produkt->ID = $id_produktu;
        }

        return $produkt;
    }

    public function deleteProdukt(Mobily $produkt, $conn):void
    {
        $produkt = $this->getProduktById($produkt->ID);

        $sql = "DELETE FROM mobily WHERE ID={$produkt->ID}";

        if ($this->conn->query($sql) !== true) {
            throw new InvalidArgumentException("Nepodarilo sa vymazat kategoriu");
        }

        $produkt->isDeleted = true;
    }
}