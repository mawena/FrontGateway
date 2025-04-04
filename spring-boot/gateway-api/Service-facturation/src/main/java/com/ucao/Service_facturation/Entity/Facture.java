package com.ucao.Service_facturation.Entity;


import com.fasterxml.jackson.annotation.JsonProperty;
import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.util.Collection;
import java.util.Date;


@NoArgsConstructor
@Data
@Entity
public class Facture {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    private Date dateFacture;

    @JsonProperty(access = JsonProperty.Access.WRITE_ONLY)
    private Long clientId;

    @Transient
    private Client client;

    @OneToMany(mappedBy = "facture_id", targetEntity = DetailFacture.class, cascade = CascadeType.REMOVE, fetch = FetchType.EAGER)
    private Collection<DetailFacture> detailFactures;


    public Facture(Long id, Date dateFacture, Long clientId, Collection<DetailFacture> detailFactures) {
        this.id = id;
        this.dateFacture = dateFacture;
        this.clientId = clientId;
        this.detailFactures = detailFactures;
    }

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public Date getDateFacture() {
        return dateFacture;
    }

    public void setDateFacture(Date dateFacture) {
        this.dateFacture = dateFacture;
    }

    public Long getClientId() {
        return clientId;
    }

    public void setClientId(Long clientId) {
        this.clientId = clientId;
    }

    public Collection<DetailFacture> getDetailFactures() {
        return detailFactures;
    }

    public void setDetailFactures(Collection<DetailFacture> detailFactures) {
        this.detailFactures = detailFactures;
    }

    public Client getClient() {
        return client;
    }

    public void setClient(Client client) {
        this.client = client;
    }
}
