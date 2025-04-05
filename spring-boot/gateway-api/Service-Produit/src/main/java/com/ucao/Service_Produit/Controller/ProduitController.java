package com.ucao.Service_Produit.Controller;


import com.ucao.Service_Produit.Entity.Produit;
import com.ucao.Service_Produit.Service.ProduitService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import org.springframework.web.bind.annotation.CrossOrigin;

@RestController
@RequestMapping("/produits")
@CrossOrigin(origins = "*", methods = {RequestMethod.GET, RequestMethod.POST, RequestMethod.PUT, RequestMethod.DELETE})

public class ProduitController {

    @Autowired
    private ProduitService produitService;

    @GetMapping
    public List<Produit> listProduit(){
        return produitService.showProduit();
    }

    @GetMapping("/{id}")
    public Produit getProduit(@PathVariable Long id){
        return produitService.getOneProduit(id);
    }

    @PostMapping
    public Produit saveProduit(@RequestBody Produit produit){
        return produitService.saveProduit(produit);
    }

    @PutMapping("/{id}")
    public ResponseEntity<Produit> updateProduit(@PathVariable Long id, @RequestBody Produit produitDetails){
        return ResponseEntity.ok(produitService.updateProduit(id, produitDetails));
    }

    @DeleteMapping("/{id}")
    public void  deleteProduit(@PathVariable Long id){
        produitService.deleteProduit(id);
    }

}
