package com.utc.ihmFilRouge.modele;

public class Client {
	
	String code_client;
	String email;
	String nom;
	String prenom;
	String civilite;
	String adresse;
	String code_postal;
	String ville;
	String pays;
	String mdp;
	
	
	public Client(String code_client, String email, String nom, String prenom,
			String civilite, String adresse, String code_postal, String ville,
			String pays, String mdp) {
		super();
		this.code_client = code_client;
		this.email = email;
		this.nom = nom;
		this.prenom = prenom;
		this.civilite = civilite;
		this.adresse = adresse;
		this.code_postal = code_postal;
		this.ville = ville;
		this.pays = pays;
		this.mdp = mdp;
	}


	public String getCode_client() {
		return code_client;
	}


	public void setCode_client(String code_client) {
		this.code_client = code_client;
	}


	public String getEmail() {
		return email;
	}


	public void setEmail(String email) {
		this.email = email;
	}


	public String getNom() {
		return nom;
	}


	public void setNom(String nom) {
		this.nom = nom;
	}


	public String getPrenom() {
		return prenom;
	}


	public void setPrenom(String prenom) {
		this.prenom = prenom;
	}


	public String getCivilite() {
		return civilite;
	}


	public void setCivilite(String civilite) {
		this.civilite = civilite;
	}


	public String getAdresse() {
		return adresse;
	}


	public void setAdresse(String adresse) {
		this.adresse = adresse;
	}


	public String getCode_postal() {
		return code_postal;
	}


	public void setCode_postal(String code_postal) {
		this.code_postal = code_postal;
	}


	public String getVille() {
		return ville;
	}


	public void setVille(String ville) {
		this.ville = ville;
	}


	public String getPays() {
		return pays;
	}


	public void setPays(String pays) {
		this.pays = pays;
	}


	public String getMdp() {
		return mdp;
	}


	public void setMdp(String mdp) {
		this.mdp = mdp;
	}
	
	

}
