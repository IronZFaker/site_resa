<?php

    class Concert {
        private $idConcert;
        private $nom;
        private $event_date;


        // Getters
        function getidConcert() : int {
          return $this->idConcert;
        }

        function getNom() : string {
          return $this->nom;
        }

        function getDate() : string {
          return $this->event_date;
        }
    }

?>
