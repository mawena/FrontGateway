package com.ucao.Clients.Controller;


import com.ucao.Clients.Entity.Client;
import com.ucao.Clients.Service.ClientService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import org.springframework.web.bind.annotation.CrossOrigin;

@RestController
@RequestMapping("/clients")
@CrossOrigin(origins = "*", methods = {RequestMethod.GET, RequestMethod.POST, RequestMethod.PUT, RequestMethod.DELETE})
public class ClientController {

    @Autowired
    private ClientService clientService;

    @GetMapping
    public List<Client> listClient(){
        return clientService.showClient();
    }

    @GetMapping("/{id}")
    public Client getClient(@PathVariable Long id){
        return clientService.getOneClient(id);
    }

    @PostMapping
    public Client saveClient(@RequestBody Client client){
        return clientService.saveClient(client);
    }

    @PutMapping("{id}")
    public ResponseEntity<Client> updateClient(@PathVariable Long id, @RequestBody Client clientDetails){
        return ResponseEntity.ok(clientService.updateClient(id, clientDetails));
    }

    @DeleteMapping("/{id}")
    public void  deleteClient(@PathVariable Long id){
        clientService.deleteClient(id);
    }

}
