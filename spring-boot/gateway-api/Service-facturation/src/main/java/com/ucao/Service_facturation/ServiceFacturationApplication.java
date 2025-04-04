package com.ucao.Service_facturation;

import com.ucao.Service_facturation.Entity.ClientService;
import com.ucao.Service_facturation.Entity.DetailFacture;
import com.ucao.Service_facturation.Entity.Facture;
import com.ucao.Service_facturation.Entity.ProduitService;
import com.ucao.Service_facturation.Repository.DetailFactureRepository;
import com.ucao.Service_facturation.Repository.FactureRepository;
import org.springframework.boot.CommandLineRunner;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.cloud.openfeign.EnableFeignClients;
import org.springframework.context.annotation.Bean;

import java.util.Date;

@SpringBootApplication
@EnableFeignClients
public class ServiceFacturationApplication {

	public static void main(String[] args) {
		SpringApplication.run(ServiceFacturationApplication.class, args);
	}

//	@Bean
//	CommandLineRunner start(FactureRepository factureRepository,
//							DetailFactureRepository detailFactureRepository,
//							ClientService clientService,
//							ProduitService produitService) {
//		return args -> {
//			Facture f1 = factureRepository.save(new Facture(null, new Date(), 1L, null));
//			detailFactureRepository.save(new DetailFacture(null, 2L, 7, 7800.0, f1.getId()));
//			detailFactureRepository.save(new DetailFacture(null, 1L, 40, 68000.0, f1.getId()));
//			detailFactureRepository.save(new DetailFacture(null, 3L, 18, 5400.0, f1.getId()));
//			detailFactureRepository.save(new DetailFacture(null, 4L, 3, 1000.0, f1.getId()));
//
//		};
//	}

}
