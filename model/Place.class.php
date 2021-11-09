<?php
    echo "in place";
    class Place {
        private $idPlace;
        private $idConcert;
        private $dispo;
        private $siege;

        // Getters
        function getidPlace() : int {
          return $this->idPlace;
        }
        function getDispo() : bool {
          return $this->dispo;
        }

        function getidConcert() : int {
          return $this->idConcert;
        }

        function getSiege() : int {
          return $this->siege;
        }


    }

?>
