<?php

    class Concert {
        private $idConcert;
        private $nom;
        private $date;


        // Getters
        function getidConcert() : int {
          return $this->idConcert;
        }

        function getNom() : string {
          return $this->nom;
        }

        function geDate() : int {
          return $this->date;
        }
    }

?>
