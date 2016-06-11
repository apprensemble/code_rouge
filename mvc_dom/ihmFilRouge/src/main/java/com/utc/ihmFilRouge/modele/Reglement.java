package com.utc.ihmFilRouge.modele;

public class Reglement {
	
	Integer num_reglement;
	Integer num_facture;
	String dt_reglement;
	Integer mode_reglement;
	
	public Reglement(Integer num_reglement, Integer num_facture,
			String dt_reglement, Integer mode_reglement) {
		super();
		this.num_reglement = num_reglement;
		this.num_facture = num_facture;
		this.dt_reglement = dt_reglement;
		this.mode_reglement = mode_reglement;
	}

	public Integer getNum_reglement() {
		return num_reglement;
	}

	public void setNum_reglement(Integer num_reglement) {
		this.num_reglement = num_reglement;
	}

	public Integer getNum_facture() {
		return num_facture;
	}

	public void setNum_facture(Integer num_facture) {
		this.num_facture = num_facture;
	}

	public String getDt_reglement() {
		return dt_reglement;
	}

	public void setDt_reglement(String dt_reglement) {
		this.dt_reglement = dt_reglement;
	}

	public Integer getMode_reglement() {
		return mode_reglement;
	}

	public void setMode_reglement(Integer mode_reglement) {
		this.mode_reglement = mode_reglement;
	}
	
	

}
