package com.ucao.Service_facturation.Service;


import com.ucao.Service_facturation.Entity.ClientService;
import com.ucao.Service_facturation.Entity.DetailFacture;
import com.ucao.Service_facturation.Entity.Facture;
import com.ucao.Service_facturation.Entity.ProduitService;
import com.ucao.Service_facturation.Repository.FactureRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class FactureService {

    @Autowired
    private FactureRepository factureRepository;

    @Autowired
    private ClientService clientService;

    @Autowired
    private ProduitService produitService;

    public List<Facture> showFacture() {
        List<Facture> factures = factureRepository.findAll();

        for (Facture facture : factures) {
            facture.setClient(clientService.findClientById(facture.getClientId()));

            if (facture.getDetailFactures() != null) {
                for (DetailFacture df : facture.getDetailFactures()) {
                    df.setProduit(produitService.findProduitById(df.getProduitId()));
                }
            }
        }

        return factures;
    }

    public Facture saveFacture(Facture facture){
        Facture saved = factureRepository.save(facture);

        // Hydrate le client à partir du clientId
        saved.setClient(clientService.findClientById(saved.getClientId()));

        return saved;
    }

    public Facture updateFacture(Long id, Facture factureDetails){
        Facture facture = factureRepository.findById(id)
                .orElseThrow(() -> new RuntimeException("Facture not found"));

        facture.setDateFacture(factureDetails.getDateFacture());
        facture.setClientId(factureDetails.getClientId());

        Facture updated = factureRepository.save(facture);

        // Hydrate le client avant de renvoyer
        updated.setClient(clientService.findClientById(updated.getClientId()));

        return updated;
    }

    public Facture getOneFacture(Long id){
        Facture facture = factureRepository.findById(id).orElseThrow(() -> new RuntimeException("Facture not found"));

        // Hydrater le client via Feign
        facture.setClient(clientService.findClientById(facture.getClientId()));

        // Hydrater les produits dans les détails (si tu as un ProduitService Feign prêt)
        if (facture.getDetailFactures() != null) {
            for (DetailFacture df : facture.getDetailFactures()) {
                // Assure-toi que produitService est bien injecté
                df.setProduit(produitService.findProduitById(df.getProduitId()));
            }
        }

        return facture;
    }

    public void deleteFacture(Long id){
        factureRepository.deleteById(id);
    }

}
