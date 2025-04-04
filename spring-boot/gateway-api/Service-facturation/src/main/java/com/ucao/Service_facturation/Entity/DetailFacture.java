package com.ucao.Service_facturation.Entity;

import com.fasterxml.jackson.annotation.JsonIgnore;
import com.fasterxml.jackson.annotation.JsonProperty;
import jakarta.persistence.*;
import lombok.Data;
import lombok.NoArgsConstructor;

@NoArgsConstructor
@Data
@Entity
public class DetailFacture {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    private double prix;

    private int quantite;

    @JsonProperty(access = JsonProperty.Access.WRITE_ONLY)
    private Long produitId;

    @Transient
    Produit produit;

    @JsonProperty(access = JsonProperty.Access.WRITE_ONLY)
    private Long facture_id;

    @JsonIgnore
    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "facture_id", insertable = false, updatable = false)
    private Facture facture;

    public Facture getFacture() {
        return facture;
    }

    public void setFacture(Facture facture) {
        this.facture = facture;
    }

    public DetailFacture(Long id, double prix, int quantite, Long produitId, Produit produit, Long facture_id, Facture facture) {
        this.id = id;
        this.prix = prix;
        this.quantite = quantite;
        this.produitId = produitId;
        this.produit = produit;
        this.facture_id = facture_id;
        this.facture = facture;
    }

    public Produit getProduit() {
        return produit;
    }

    public void setProduit(Produit produit) {
        this.produit = produit;
    }

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public double getPrix() {
        return prix;
    }

    public void setPrix(double prix) {
        this.prix = prix;
    }

    public int getQuantite() {
        return quantite;
    }

    public void setQuantite(int quantite) {
        this.quantite = quantite;
    }

    public Long getProduitId() {
        return produitId;
    }

    public void setProduitId(Long produitId) {
        this.produitId = produitId;
    }

    public Long getFacture_id() {
        return facture_id;
    }

    public void setFacture_id(Long facture_id) {
        this.facture_id = facture_id;
    }
}
