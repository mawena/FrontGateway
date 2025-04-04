package com.ucao.Clients.Service;


import com.ucao.Clients.Entity.Client;
import com.ucao.Clients.Repository.ClientRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class ClientService {

    @Autowired
    private ClientRepository clientRepository;

    public List<Client> showClient() {
        return clientRepository.findAll();
    }

    public Client saveClient(Client client){
        return clientRepository.save(client);
    }

    public Client updateClient(Long id, Client clientdetails){
        Client client =clientRepository.findById(id).orElseThrow(() -> new RuntimeException("Client not found"));
        client.setNom(clientdetails.getNom());
        client.setPrenom(clientdetails.getPrenom());
        client.setEmail(clientdetails.getEmail());
        return clientRepository.save(client);
    }

    public Client getOneClient(Long id){
        return clientRepository.findById(id).get();
    }

    public void deleteClient(Long id){
        clientRepository.deleteById(id);
    }

}
