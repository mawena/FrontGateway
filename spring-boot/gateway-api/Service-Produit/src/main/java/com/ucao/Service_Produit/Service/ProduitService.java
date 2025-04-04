package com.ucao.Service_Produit.Service;


import com.ucao.Service_Produit.Entity.Produit;
import com.ucao.Service_Produit.Repository.ProduitRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class ProduitService {

    @Autowired
    private ProduitRepository produitRepository;

    public List<Produit> showProduit() {
        return produitRepository.findAll();
    }

    public Produit saveProduit(Produit produit){
        return produitRepository.save(produit);
    }

    public Produit updateProduit(Long id, Produit produitDetails){
        Produit produit =produitRepository.findById(id).orElseThrow(() -> new RuntimeException("Produit not found"));
        produit.setNom(produitDetails.getNom());
        produit.setPrix(produitDetails.getPrix());
        return produitRepository.save(produit);
    }

    public Produit getOneProduit(Long id){
        return produitRepository.findById(id).get();
    }

    public void deleteProduit(Long id){
        produitRepository.deleteById(id);
    }

}
