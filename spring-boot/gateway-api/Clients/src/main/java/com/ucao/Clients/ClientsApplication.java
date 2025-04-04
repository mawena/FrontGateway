package com.ucao.Clients;

import com.ucao.Clients.Entity.Client;
import com.ucao.Clients.Repository.ClientRepository;
import org.springframework.boot.CommandLineRunner;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.Bean;
import org.springframework.data.rest.core.config.RepositoryRestConfiguration;

@SpringBootApplication
public class ClientsApplication {

	public static void main(String[] args) {
		SpringApplication.run(ClientsApplication.class, args);
	}

	@Bean
	CommandLineRunner start(ClientRepository clientRepository,
							RepositoryRestConfiguration restConfiguration) {
		return args -> {
			restConfiguration.exposeIdsFor(Client.class);
			clientRepository.save(new Client(null, "DJERI", "Francis", "francis@gmail.com"));
			clientRepository.save(new Client(null, "KOUDOSSOU", "Justin", "Justin@gmail.com"));
			clientRepository.save(new Client(null, "KPATA", "Albertine", "Albertine@gmail.com"));
			clientRepository.save(new Client(null, "ZRIN-DESSI", "Franck", "Franck@gmail.com"));
			clientRepository.save(new Client(null, "ZOMIYIKOU", "Hortance", "Hortance@gmail.com"));

		};
	}
}
