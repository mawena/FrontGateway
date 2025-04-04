package com.ucao.Service_facturation.Repository;


import com.ucao.Service_facturation.Entity.DetailFacture;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface DetailFactureRepository extends JpaRepository<DetailFacture, Long> {
}
