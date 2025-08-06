<?php

    class User {
        public function __construct(
            private $nom,
            private $prenom,
            private $username,
            private $email,
            private $password,
            private $role = "client",
            private $is_verified = false,
            private $is_deleted = false,
            private $is_active = false,
        ) {}
        public function getIsVerified(): bool { return $this->is_verified; }
        public function getIsDeleted(): bool { return $this->is_deleted; } 
        public function getIsActive(): bool { return $this->is_active; }
        public function setIsVerified(bool $is_verified): void { $this->is_verified = $is_verified; }
        public function setIsDeleted(bool $is_deleted): void { $this->is_deleted = $is_deleted; }
        public function setIsActive(bool $is_active): void { $this->is_active = $is_active; }
        public function getNom(): string { return $this->nom; }
        public function getPenom(): string { return $this->prenom; }
        public function getUsername(): string { return $this->username; }
        public function getEmail(): string { return $this->email; }
        public function getRole(): string { return $this->role; }
        public function getPassword(): string { return $this->password; }
        public function setNom(string $nom): void { $this->nom = $nom; }
        public function setPrenom(string $prenom): void { $this->prenom = $prenom;}
        public function setUsername(string $username): void { $this->username = $username; }
        public function setEmail(string $email): void { $this->email = $email;}
        public function setRole(string $role): void { $this->role = $role; }
        public function setPassword(string $password): void { $this->password = $password; }
        
        public function toArray(): array {
            return [
                'nom' => $this->nom,
                'prenom' => $this->prenom,
                'username' => $this->username,
                'email' => $this->email,
             
                'password' => $this->password,
                   'role' => $this->role
            ];
        }

        public static function fromArray(array $data): User {
            return new self(
                $data['nom'] ?? '',
                $data['prenom'] ?? '',
                $data['username'] ?? '',
                $data['email'] ?? '',
                $data['password'] ?? '',
                $data['role'] ?? ''
            );
        }

    
    }