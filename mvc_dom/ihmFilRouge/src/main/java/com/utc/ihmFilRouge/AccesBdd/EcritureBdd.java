package com.utc.ihmFilRouge.AccesBdd;

import java.io.File;
import java.io.IOException;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.Date;
import java.text.SimpleDateFormat;
import java.util.Calendar;

import com.fasterxml.jackson.core.JsonGenerationException;
import com.fasterxml.jackson.databind.JsonMappingException;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.utc.ihmFilRouge.modele.Produit;



public class EcritureBdd {


	static Date creation = Calendar.getInstance().getTime();

	static SimpleDateFormat formater = new SimpleDateFormat("dd/MM/yyyy");
	// S'utilise comme ca: formater.format(relance)
	
	/**
	 * @param args
	 */
	
	
	
	public static void ajouterProduitAuPanier(String code_client, String code_prod, Integer qte, 
												String prix_HT, String TVA ) {
		// information d'acces a la base de donnees
		String url = "jdbc:mysql://localhost/gestion_site";
		String login = "root";
		String passwd = "";
		
		java.sql.Connection cn = null;
		java.sql.Statement st = null;

		try {
			// Etape 1: Chargement du driver
			Class.forName("com.mysql.jdbc.Driver");
			// Etape 2: recuperation de la connection
			cn = DriverManager.getConnection(url, login, passwd);
			// Etape 3: creation d'un statement
			st = cn.createStatement();
			Double prix_HT_DB = Double.parseDouble(prix_HT);
			Double TVA_DB = Double.parseDouble(TVA);
			
			String sql = "INSERT INTO produits_panier (code_client, code_prod, qte, prix_HT, TVA) " +
				"VALUES ('"+ code_client +"' , '"+ code_prod +"' , '"+ qte +"' , '"+ prix_HT_DB +"' , '"+ TVA_DB +"');";
		
			
			//Etape 4: execution requete

			System.out.println(sql.toString());
			st.executeUpdate(sql);
			
			
			
		} catch (SQLException e) {
			e.printStackTrace();
		} catch (ClassNotFoundException e) {
			e.printStackTrace();
		} finally {
			try {
				// Etape 5: liberer de la memoire
				cn.close();
				st.close();
			} catch (SQLException e) {
				e.printStackTrace();
			}
		}
	}

	public static void supprimerProduitAuPanier(String code_client, String code_prod ) {
		// information d'acces a la base de donnees
		String url = "jdbc:mysql://localhost/gestion_site";
		String login = "root";
		String passwd = "";
		
		java.sql.Connection cn = null;
		java.sql.Statement st = null;
		
		try {
			// Etape 1: Chargement du driver
			Class.forName("com.mysql.jdbc.Driver");
			// Etape 2: recuperation de la connection
			cn = DriverManager.getConnection(url, login, passwd);
			// Etape 3: creation d'un statement
			st = cn.createStatement();

			
			String sql = "DELETE FROM produits_panier WHERE code_client = '"+ code_client +"' and code_prod = '"+ code_prod +"';";
			
			
			//Etape 4: execution requete
			System.out.println(sql.toString());
			st.executeUpdate(sql);
			
			
			
		} catch (SQLException e) {
			e.printStackTrace();
			} catch (ClassNotFoundException e) {
			e.printStackTrace();
			} finally {
		try {
			// Etape 5: liberer de la memoire
			cn.close();
			st.close();
		} catch (SQLException e) {
			e.printStackTrace();
		}
		}
	}
	
	
	public static void viderPanier() {
		// information d'acces a la base de donnees
		String url = "jdbc:mysql://localhost/gestion_site";
		String login = "root";
		String passwd = "";
		
		java.sql.Connection cn = null;
		java.sql.Statement st = null;
		
		try {
			// Etape 1: Chargement du driver
			Class.forName("com.mysql.jdbc.Driver");
			// Etape 2: recuperation de la connection
			cn = DriverManager.getConnection(url, login, passwd);
			// Etape 3: creation d'un statement
			st = cn.createStatement();

			
			String sql = "DELETE FROM produits_panier;";
			
			
			//Etape 4: execution requete
			System.out.println(sql.toString());
			st.executeUpdate(sql);
			
			
			
		} catch (SQLException e) {
			e.printStackTrace();
			} catch (ClassNotFoundException e) {
			e.printStackTrace();
			} finally {
		try {
			// Etape 5: liberer de la memoire
			cn.close();
			st.close();
		} catch (SQLException e) {
			e.printStackTrace();
		}
		}
	}
	
	public static void modifierPrixTtc(Double TTC, String client) {
		// information d'acces a la base de donnees
		String url = "jdbc:mysql://localhost/gestion_site";
		String login = "root";
		String passwd = "";
		
		java.sql.Connection cn = null;
		java.sql.Statement st = null;
		
		try {
			// Etape 1: Chargement du driver
			Class.forName("com.mysql.jdbc.Driver");
			// Etape 2: recuperation de la connection
			cn = DriverManager.getConnection(url, login, passwd);
			// Etape 3: creation d'un statement
			st = cn.createStatement();

			
			String sql = "UPDATE panier SET montant_total_ttc="+TTC+" WHERE code_client="+client+";";
			
			
			//Etape 4: execution requete
			System.out.println(sql.toString());
			st.executeUpdate(sql);
			
			
			
		} catch (SQLException e) {
			e.printStackTrace();
			} catch (ClassNotFoundException e) {
			e.printStackTrace();
			} finally {
		try {
			// Etape 5: liberer de la memoire
			cn.close();
			st.close();
		} catch (SQLException e) {
			e.printStackTrace();
		}
		}
	}
	
}

