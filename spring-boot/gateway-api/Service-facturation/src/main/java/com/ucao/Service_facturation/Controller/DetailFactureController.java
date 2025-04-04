package com.ucao.Service_facturation.Controller;


import com.ucao.Service_facturation.Entity.DetailFacture;
import com.ucao.Service_facturation.Service.DetailFactureService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
public class DetailFactureController {

    @Autowired
    private DetailFactureService factureDetailsService;

    @GetMapping("/factureDetails")
    public List<DetailFacture> listFactureDetails(){
        return factureDetailsService.showFactureDetails();
    }

    @GetMapping("/factureDetails/{id}")
    public DetailFacture getfactureDetails(@PathVariable Long id){
        return factureDetailsService.getOneFactureDetails(id);
    }

    @PostMapping("/factureDetails")
    public DetailFacture savefactureDetails(@RequestBody DetailFacture factureDetails){
        return factureDetailsService.saveFactureDetails(factureDetails);
    }

    @PutMapping("/factureDetails/{id}")
    public ResponseEntity<DetailFacture> updatefactureDetails(@PathVariable Long id, @RequestBody DetailFacture factureDetails){
        return ResponseEntity.ok(factureDetailsService.updateFactureDetails(id, factureDetails));
    }

    @DeleteMapping("/factureDetails/{id}")
    public void  deletefactureDetails(@PathVariable Long id){
        factureDetailsService.deleteFactureDetails(id);
    }

}
