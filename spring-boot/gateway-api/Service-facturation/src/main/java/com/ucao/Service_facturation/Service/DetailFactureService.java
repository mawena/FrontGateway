package com.ucao.Service_facturation.Service;


import com.ucao.Service_facturation.Entity.DetailFacture;
import com.ucao.Service_facturation.Entity.ProduitService;
import com.ucao.Service_facturation.Repository.DetailFactureRepository;
import com.ucao.Service_facturation.Repository.FactureRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class DetailFactureService {

    @Autowired
    private DetailFactureRepository factureDetailsRepository;

    @Autowired
    private ProduitService produitService;

    @Autowired
    private FactureRepository factureRepository;

    public List<DetailFacture> showFactureDetails() {
        List<DetailFacture> details = factureDetailsRepository.findAll();

        for (DetailFacture df : details) {
            df.setProduit(produitService.findProduitById(df.getProduitId()));
        }

        return details;
    }

    public DetailFacture saveFactureDetails(DetailFacture factureDetails){
        DetailFacture saved = factureDetailsRepository.save(factureDetails);

        // Hydratation
        saved.setProduit(produitService.findProduitById(factureDetails.getProduitId()));
        saved.setFacture(factureRepository.findById(factureDetails.getFacture_id()).orElse(null));

        return saved;
    }

    public DetailFacture updateFactureDetails(Long id, DetailFacture contenuFactureDetails){
        DetailFacture factureDetails = factureDetailsRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Facture details not found"));

        // Mise à jour des champs
        factureDetails.setQuantite(contenuFactureDetails.getQuantite());
        factureDetails.setPrix(contenuFactureDetails.getPrix());
        factureDetails.setProduitId(contenuFactureDetails.getProduitId());
        factureDetails.setFacture_id(contenuFactureDetails.getFacture_id());

        // Sauvegarde
        DetailFacture saved = factureDetailsRepository.save(factureDetails);

        // Hydratation pour réponse enrichie
        saved.setProduit(produitService.findProduitById(saved.getProduitId()));
        saved.setFacture(factureRepository.findById(saved.getFacture_id()).orElse(null));

        return saved;
    }

    public DetailFacture getOneFactureDetails(Long id){
        DetailFacture detail = factureDetailsRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Facture detail not found"));

        // Hydratation manuelle du produit
        detail.setProduit(produitService.findProduitById(detail.getProduitId()));

        return detail;
    }

    public void deleteFactureDetails(Long id){
        factureDetailsRepository.deleteById(id);
    }

}
