package com.utc.ihmFilRouge.modele;

public class Produits_panier {
	
	String code_client;
	String code_prod;
	Integer qte;
	String prix_HT;
	String TVA;
	String TTC;
	
	public Produits_panier(String code_client, String code_prod, Integer qte,
			String prix_HT, String tVA, String TTC) {
		super();
		this.code_client = code_client;
		this.code_prod = code_prod;
		this.qte = qte;
		this.prix_HT = prix_HT;
		this.TVA = tVA;
		this.TTC = TTC;
	}

	public String getCode_client() {
		return code_client;
	}

	public void setCode_client(String code_client) {
		this.code_client = code_client;
	}

	public String getCode_prod() {
		return code_prod;
	}

	public void setCode_prod(String code_prod) {
		this.code_prod = code_prod;
	}

	public Integer getQte() {
		return qte;
	}

	public void setQte(Integer qte) {
		this.qte = qte;
	}

	public String getPrix_HT() {
		return prix_HT;
	}

	public void setPrix_HT(String prix_HT) {
		this.prix_HT = prix_HT;
	}

	public String getTVA() {
		return TVA;
	}

	public void setTVA(String tVA) {
		TVA = tVA;
	}
	
	public String getTTC() {
		return TTC;
	}

	public void setTTC(String tTC) {
		TTC = tTC;
	}

}
