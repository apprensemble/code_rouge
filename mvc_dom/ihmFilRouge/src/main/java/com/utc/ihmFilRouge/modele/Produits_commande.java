package com.utc.ihmFilRouge.modele;

public class Produits_commande {
	
	Integer num_cde;
	String code_prod;
	Integer qte_cde;
	String prix_HT;
	String TVA;
	
	public Produits_commande(Integer num_cde, String code_prod,
			Integer qte_cde, String prix_HT, String tVA) {
		super();
		this.num_cde = num_cde;
		this.code_prod = code_prod;
		this.qte_cde = qte_cde;
		this.prix_HT = prix_HT;
		TVA = tVA;
	}

	public Integer getNum_cde() {
		return num_cde;
	}

	public void setNum_cde(Integer num_cde) {
		this.num_cde = num_cde;
	}

	public String getCode_prod() {
		return code_prod;
	}

	public void setCode_prod(String code_prod) {
		this.code_prod = code_prod;
	}

	public Integer getQte_cde() {
		return qte_cde;
	}

	public void setQte_cde(Integer qte_cde) {
		this.qte_cde = qte_cde;
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
	
	

}
