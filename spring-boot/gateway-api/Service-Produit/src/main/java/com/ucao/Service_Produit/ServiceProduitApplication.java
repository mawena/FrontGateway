package com.ucao.Service_Produit;

import com.ucao.Service_Produit.Entity.Produit;
import com.ucao.Service_Produit.Repository.ProduitRepository;
import org.springframework.boot.CommandLineRunner;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.Bean;
import org.springframework.data.rest.core.config.RepositoryRestConfiguration;

@SpringBootApplication
public class ServiceProduitApplication {

	public static void main(String[] args) {
		SpringApplication.run(ServiceProduitApplication.class, args);
	}

	@Bean
	CommandLineRunner start(ProduitRepository produitRepository,
							RepositoryRestConfiguration restConfiguration){
		return args -> {
			restConfiguration.exposeIdsFor(Produit.class);
			produitRepository.save(new Produit(null, 10000.0, "poulet"));
			produitRepository.save(new Produit(null, 6000.0, "souris"));
			produitRepository.save(new Produit(null, 45000.0, "ecran"));
			produitRepository.save(new Produit(null, 32000.0, "ram"));
			produitRepository.save(new Produit(null, 5000.0, "pantalon"));
		};
	}

}
