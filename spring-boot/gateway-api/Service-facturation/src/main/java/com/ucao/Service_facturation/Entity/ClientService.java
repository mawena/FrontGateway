package com.ucao.Service_facturation.Entity;


import org.springframework.cloud.openfeign.FeignClient;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;

@FeignClient(name = "SERVICE-CLIENTS")
public interface ClientService {

    @GetMapping("/clients/{id}")
    public Client findClientById(@PathVariable(name = "id")Long id);

}
