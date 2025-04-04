package com.ucao.Service_facturation.Projection;

import com.ucao.Service_facturation.Entity.DetailFacture;

import java.util.Collection;
import java.util.Date;

public interface FactureProjection {
    public Long getId();
    public Date getDateFacture();
    public Long getClientId();
    public Collection<DetailFacture> getDetailFactures();
}
