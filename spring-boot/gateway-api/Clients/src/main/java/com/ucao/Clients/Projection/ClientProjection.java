package com.ucao.Clients.Projection;


import com.ucao.Clients.Entity.Client;
import org.springframework.data.rest.core.config.Projection;

@Projection(name = "P1", types = Client.class)
public interface ClientProjection {

    public Long getId();
    public String getNom();

}
