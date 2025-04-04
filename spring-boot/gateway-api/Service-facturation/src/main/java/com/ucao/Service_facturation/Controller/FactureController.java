package com.ucao.Service_facturation.Controller;


import com.ucao.Service_facturation.Entity.ClientService;
import com.ucao.Service_facturation.Entity.Facture;
import com.ucao.Service_facturation.Entity.ProduitService;
import com.ucao.Service_facturation.Repository.DetailFactureRepository;
import com.ucao.Service_facturation.Repository.FactureRepository;
import com.ucao.Service_facturation.Service.FactureService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/factures")
public class FactureController {

    @Autowired
    private FactureService factureService;

    @Autowired
    private ClientService clientService;

    @Autowired
    private ProduitService produitService;

    @Autowired
    private FactureRepository factureRepository;

    @Autowired
    private DetailFactureRepository detailFactureRepository;

    @GetMapping("/pf/{id}")
    public Facture getFactures(@PathVariable("id")Long id){
        Facture facture = factureRepository.findById(id).get();
        facture.setClient(clientService.findClientById(facture.getClientId()));
        facture.getDetailFactures().forEach(p->{
            p.setProduit(produitService.findProduitById(p.getProduitId()));
        });
        return facture;
    }

    @GetMapping
    public List<Facture> listFacture(){
        return factureService.showFacture();
    }

    @GetMapping("/{id}")
    public Facture getFacture(@PathVariable Long id){
        return factureService.getOneFacture(id);
    }

    @PostMapping
    public Facture saveFacture(@RequestBody Facture facture){
        return factureService.saveFacture(facture);
    }

    @PutMapping("/{id}")
    public ResponseEntity<Facture> updateFacture(@PathVariable Long id, @RequestBody Facture facture){
        return ResponseEntity.ok(factureService.updateFacture(id, facture));
    }

    @DeleteMapping("/{id}")
    public void  deleteFacture(@PathVariable Long id){
        factureService.deleteFacture(id);
    }

}
