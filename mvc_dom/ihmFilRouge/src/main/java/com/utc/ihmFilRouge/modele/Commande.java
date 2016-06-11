package com.utc.ihmFilRouge.modele;

public class Commande {
	
	Integer num_cde;
	String code_client;
	String dt_cde;
	
	public Commande(Integer num_cde, String code_client, String dt_cde) {
		super();
		this.num_cde = num_cde;
		this.code_client = code_client;
		this.dt_cde = dt_cde;
	}

	public Integer getNum_cde() {
		return num_cde;
	}

	public void setNum_cde(Integer num_cde) {
		this.num_cde = num_cde;
	}

	public String getCode_client() {
		return code_client;
	}

	public void setCode_client(String code_client) {
		this.code_client = code_client;
	}

	public String getDt_cde() {
		return dt_cde;
	}

	public void setDt_cde(String dt_cde) {
		this.dt_cde = dt_cde;
	}

	
}
