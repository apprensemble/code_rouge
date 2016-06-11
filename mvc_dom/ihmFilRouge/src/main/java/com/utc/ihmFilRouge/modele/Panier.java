package com.utc.ihmFilRouge.modele;

public class Panier {
	
	String code_client;
	Double montant_total_ttc;
	String dt_panier;
	
	public Panier(String code_client, Double montant_total_ttc,
			String dt_panier) {
		super();
		this.code_client = code_client;
		this.montant_total_ttc = montant_total_ttc;
		this.dt_panier = dt_panier;
	}

	public String getCode_client() {
		return code_client;
	}

	public void setCode_client(String code_client) {
		this.code_client = code_client;
	}

	public Double getMontant_total_ttc() {
		return montant_total_ttc;
	}

	public void setMontant_total_ttc(Double montant_total_ttc) {
		this.montant_total_ttc = montant_total_ttc;
	}

	public String getDt_panier() {
		return dt_panier;
	}

	public void setDt_panier(String dt_panier) {
		this.dt_panier = dt_panier;
	}
	
	

}
