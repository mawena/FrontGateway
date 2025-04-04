package com.ucao.Service_facturation.Entity;


import org.springframework.cloud.openfeign.FeignClient;
import org.springframework.data.web.PagedModel;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;

@FeignClient(name = "SERVICE-PRODUIT")
public interface ProduitService {

    @GetMapping("/produits/{id}")
    public Produit findProduitById(@PathVariable("id") Long id);

    @GetMapping("/Produits")
    public PagedModel<Produit> findAllProduits();

}
