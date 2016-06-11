package com.utc.ihmFilRouge.modele;

public class Facture {

	Integer num_facture;
	Integer num_cde;
	String dt_facture;
	Integer montant_total;
	Integer reglement_OK;
	
	public Facture(Integer num_facture, Integer num_cde, String dt_facture,
			Integer montant_total, Integer reglement_OK) {
		super();
		this.num_facture = num_facture;
		this.num_cde = num_cde;
		this.dt_facture = dt_facture;
		this.montant_total = montant_total;
		this.reglement_OK = reglement_OK;
	}

	public Integer getNum_facture() {
		return num_facture;
	}

	public void setNum_facture(Integer num_facture) {
		this.num_facture = num_facture;
	}

	public Integer getNum_cde() {
		return num_cde;
	}

	public void setNum_cde(Integer num_cde) {
		this.num_cde = num_cde;
	}

	public String getDt_facture() {
		return dt_facture;
	}

	public void setDt_facture(String dt_facture) {
		this.dt_facture = dt_facture;
	}

	public Integer getMontant_total() {
		return montant_total;
	}

	public void setMontant_total(Integer montant_total) {
		this.montant_total = montant_total;
	}

	public Integer getReglement_OK() {
		return reglement_OK;
	}

	public void setReglement_OK(Integer reglement_OK) {
		this.reglement_OK = reglement_OK;
	}
	
	
}
