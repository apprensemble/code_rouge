package com.utc.ihmFilRouge.controleur;

import java.util.List;

import org.springframework.stereotype.Controller;
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;

import com.utc.ihmFilRouge.AccesBdd.AccesBdd;
import com.utc.ihmFilRouge.AccesBdd.EcritureBdd;
import com.utc.ihmFilRouge.modele.Client;
import com.utc.ihmFilRouge.modele.Panier;
import com.utc.ihmFilRouge.modele.Produit;
import com.utc.ihmFilRouge.modele.Produits_commande;
import com.utc.ihmFilRouge.modele.Produits_panier;

@Controller
public class HelloControleur {
	
	@RequestMapping (path = "/coucou")
	public String coucou (@RequestParam(value="nom", required=false) String leNom, ModelMap model) {
		model.addAttribute("attrb", leNom);
		return "Coucou";
		//il va aller chercher le jsp
		
	}
	
	@RequestMapping (path = "/sauverDemande")
	public String sauverDemande (@RequestParam(value="ref", required=true) Integer ref, 
								@RequestParam (value="contenu", required=true) String contenu, 
								@RequestParam (value="dest", required=true) String dest,
								@RequestParam (value="createur", required=true) String createur,
								@RequestParam (value="status", required=true) String status,
								ModelMap model) {
		//Demande ask = new Demande(ref, contenu, dest, createur, status);
	//	AccesBdd.sauverEnBase(ref, contenu, dest, createur, status);
		//model.addAttribute("dem", ask);
		return "Coucou";
		//il va aller chercher le jsp
		
	}
	
	@RequestMapping (path = "/lireDemandes")
	public String lireDemandes (ModelMap model) {
	//	AccesBdd.lireEnBase();
		return "Coucou";
	}
	
	@CrossOrigin(origins = "http://localhost:8000")
	@RequestMapping (path = "/lireProduits")
	public @ResponseBody List<Produit> lireProduits (ModelMap model) {
		List<Produit> resultats = AccesBdd.lireProduits();
		return resultats;
	}
	
	@CrossOrigin(origins = "http://localhost:8000")
	@RequestMapping (path = "/lireProduitsCommandes")
	public @ResponseBody List<Produits_commande> lireProduitsCommandes (ModelMap model) {
		List<Produits_commande> resultats = AccesBdd.lireProduitsCommandes();
		return resultats;
	}
	
	@CrossOrigin(origins = "http://localhost:8000")
	@RequestMapping (path = "/lireClients")
	public @ResponseBody List<Client> lireClients (ModelMap model) {
		List<Client> resultats = AccesBdd.lireClients();
		return resultats;
	}
	
	@CrossOrigin(origins = "http://localhost:8000")
	@RequestMapping (path = "/lireProduitsPanier")
	public @ResponseBody List<Produits_panier> lireProduitsPanier (ModelMap model) {
		List<Produits_panier> resultats = AccesBdd.lireProduitsPanier();
		return resultats;
	}
	
	@CrossOrigin(origins = "http://localhost:8000")
	@RequestMapping (path = "/lirePanier")
	public @ResponseBody List<Panier> lirePanier (ModelMap model) {
		List<Panier> resultats = AccesBdd.lirePanier();
		return resultats;
	}
	
	@CrossOrigin(origins = "http://localhost:8000")
	@RequestMapping (path = "/ajouterProduitAuPanier")
	public @ResponseBody String ajouterProduitAuPanier (@RequestParam(value="code_client", required=true) String code_client, 
														@RequestParam (value="code_prod", required=true) String code_prod, 
														@RequestParam (value="qte", required=true) Integer qte,
														@RequestParam (value="prix_HT", required=true) String prix_HT,
														@RequestParam (value="tVA", required=true) String tVA,
														ModelMap model) {
		EcritureBdd.ajouterProduitAuPanier(code_client, code_prod, qte, prix_HT, tVA);
		return "ok";
	}

	@CrossOrigin(origins = "http://localhost:8000")
	@RequestMapping (path = "/supprimerProduitAuPanier")
	public @ResponseBody String supprimerProduitAuPanier (@RequestParam(value="code_client", required=true) String code_client, 
														@RequestParam (value="code_prod", required=true) String code_prod, 
														ModelMap model) {
		EcritureBdd.supprimerProduitAuPanier(code_client, code_prod);
		return "ok";
	}
	
	
	@CrossOrigin(origins = "http://localhost:8000")
	@RequestMapping (path = "/viderPanier")
	public @ResponseBody String viderPanier (ModelMap model) {
		EcritureBdd.viderPanier();
		return "ok";
	}

	@CrossOrigin(origins = "http://localhost:8000")
	@RequestMapping (path = "/modifierPrixTtc")
	public @ResponseBody String modifierPrixTtc (@RequestParam(value="TTC", required=true) Double TTC,
												@RequestParam(value="code_client", required=true) String code_client,
												ModelMap model) {
		EcritureBdd.modifierPrixTtc(TTC, code_client);
		return "ok";
	}
	
}
