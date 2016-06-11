package beans;

import java.io.Serializable;

public class Produit implements Serializable {
	
	/**
	 *
	 */
	private static final long serialVersionUID = 1L;
	String code_prod;
	String lib_prod;
	String desc_court;
	String desc_long;
	String dt_debut;
	String dt_fin;
	String pric_HT;
	String TVA;
	String commentaires;
	String photo;
	Integer stock_qte;
	
	public Produit(String code_prod, String lib_prod, String desc_court,
			String desc_long, String dt_debut, String dt_fin, String pric_HT,
			String tVA, String commentaires, String photo, Integer stock_qte) {
		super();
		this.code_prod = code_prod;
		this.lib_prod = lib_prod;
		this.desc_court = desc_court;
		this.desc_long = desc_long;
		this.dt_debut = dt_debut;
		this.dt_fin = dt_fin;
		this.pric_HT = pric_HT;
		//WTF?!?! pourquoi un petit t et un grand VA???
		TVA = tVA;
		this.commentaires = commentaires;
		this.photo = photo;
		this.stock_qte = stock_qte;
	}

	public String getCode_prod() {
		return code_prod;
	}

	public void setCode_prod(String code_prod) {
		this.code_prod = code_prod;
	}

	public String getLib_prod() {
		return lib_prod;
	}

	public void setLib_prod(String lib_prod) {
		this.lib_prod = lib_prod;
	}

	public String getDesc_court() {
		return desc_court;
	}

	public void setDesc_court(String desc_court) {
		this.desc_court = desc_court;
	}

	public String getDesc_long() {
		return desc_long;
	}

	public void setDesc_long(String desc_long) {
		this.desc_long = desc_long;
	}

	public String getDt_debut() {
		return dt_debut;
	}

	public void setDt_debut(String dt_debut) {
		this.dt_debut = dt_debut;
	}

	public String getDt_fin() {
		return dt_fin;
	}

	public void setDt_fin(String dt_fin) {
		this.dt_fin = dt_fin;
	}

	public String getPric_HT() {
		return pric_HT;
	}

	public void setPric_HT(String pric_HT) {
		this.pric_HT = pric_HT;
	}

	public String getTVA() {
		return TVA;
	}

	public void setTVA(String tVA) {
		TVA = tVA;
	}

	public String getCommentaires() {
		return commentaires;
	}

	public void setCommentaires(String commentaires) {
		this.commentaires = commentaires;
	}

	public String getPhoto() {
		return photo;
	}

	public void setPhoto(String photo) {
		this.photo = photo;
	}

	public Integer getStock_qte() {
		return stock_qte;
	}

	public void setStock_qte(Integer stock_qte) {
		this.stock_qte = stock_qte;
	}
}
