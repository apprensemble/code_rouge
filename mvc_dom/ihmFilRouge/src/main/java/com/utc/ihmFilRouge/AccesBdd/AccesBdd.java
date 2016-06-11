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
import com.utc.ihmFilRouge.modele.Client;
import com.utc.ihmFilRouge.modele.Panier;
import com.utc.ihmFilRouge.modele.Produit;
import com.utc.ihmFilRouge.modele.Produits_commande;
import com.utc.ihmFilRouge.modele.Produits_panier;



public class AccesBdd {


	static Date creation = Calendar.getInstance().getTime();
	static Date relance = null;
	static SimpleDateFormat formater = new SimpleDateFormat("dd/MM/yyyy");
	// S'utilise comme ca: formater.format(relance)
	
	/**
	 * @param args
	 */
	

	

	
	public static ArrayList<Produit> lireProduits () {
		
		ArrayList<Produit> resultat = new ArrayList<Produit>();
		Produit asked;
		
		String url = "jdbc:mysql://localhost:8889/gestion_site";
		String login = "root";
		String passwd = "root";
		java.sql.Connection cn = null;
		
		try {
			Class.forName("com.mysql.jdbc.Driver");
			cn = DriverManager.getConnection(url, login, passwd);
			Statement st1 = (Statement) cn.createStatement();
			String sql = "SELECT * FROM produit;";
			ResultSet resultat1 = (ResultSet) st1.executeQuery(sql);
			while (resultat1.next()) {
			    //System.out.print("Colonne 1 renvoy�e ");
			    System.out.println(resultat1.getString(1));
			    System.out.println(resultat1.getString(2));
			    System.out.println(resultat1.getString(3));
			    System.out.println(resultat1.getString(4));
			    System.out.println(resultat1.getString(5));
			    System.out.println(resultat1.getString(6));
			    System.out.println(resultat1.getString(7));
			    System.out.println(resultat1.getString(8));
			    System.out.println(resultat1.getString(9));
			    System.out.println(resultat1.getString(10));
			    System.out.println(resultat1.getString(11));
			    
			    //resultat = resultat+" "+resultat1.getString(1);
			    //Integer ref = 1; //Integer.parseInt(resultat1.getString(1)); // a passer en integer
			    asked = new Produit(resultat1.getString(1), resultat1.getString(2), resultat1.getString(3), 
			    					resultat1.getString(4), resultat1.getString(5), resultat1.getString(6), 
			    					resultat1.getString(7), resultat1.getString(8), resultat1.getString(9),
			    					resultat1.getString(10), Integer.parseInt(resultat1.getString(11)) );
			    resultat.add(asked);
			}
		} catch (ClassNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		//System.out.println(resultat);
		return resultat;
		
	}
	
	public static ArrayList<Produits_commande> lireProduitsCommandes () {
		
		ArrayList<Produits_commande> resultat = new ArrayList<Produits_commande>();
		Produits_commande asked;
		
		String url = "jdbc:mysql://localhost:8889/gestion_site";
		String login = "root";
		String passwd = "root";
		java.sql.Connection cn = null;
		
		try {
			Class.forName("com.mysql.jdbc.Driver");
			cn = DriverManager.getConnection(url, login, passwd);
			Statement st1 = (Statement) cn.createStatement();
			String sql = "SELECT * FROM produits_commande;";
			ResultSet resultat1 = (ResultSet) st1.executeQuery(sql);
			while (resultat1.next()) {
			    //System.out.print("Colonne 1 renvoy�e ");
			    System.out.println(resultat1.getString(1));
			    System.out.println(resultat1.getString(2));
			    System.out.println(resultat1.getString(3));
			    System.out.println(resultat1.getString(4));
			    System.out.println(resultat1.getString(5));
			    
			    //resultat = resultat+" "+resultat1.getString(1);
			    //Integer ref = 1; //Integer.parseInt(resultat1.getString(1)); // a passer en integer
			    asked = new Produits_commande(Integer.parseInt(resultat1.getString(1)), resultat1.getString(2), Integer.parseInt(resultat1.getString(3)), 
			    		resultat1.getString(4), resultat1.getString(5));
			    resultat.add(asked);
			}
		} catch (ClassNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		//System.out.println(resultat);
		return resultat;
		
	}

	public static ArrayList<Client> lireClients () {
		
		ArrayList<Client> resultat = new ArrayList<Client>();
		Client asked;
		
		String url = "jdbc:mysql://localhost:8889/gestion_site";
		String login = "root";
		String passwd = "root";
		java.sql.Connection cn = null;
		
		try {
			Class.forName("com.mysql.jdbc.Driver");
			cn = DriverManager.getConnection(url, login, passwd);
			Statement st1 = (Statement) cn.createStatement();
			String sql = "SELECT * FROM Client;";
			ResultSet resultat1 = (ResultSet) st1.executeQuery(sql);
			while (resultat1.next()) {
			    //System.out.print("Colonne 1 renvoy�e ");
			    System.out.println(resultat1.getString(1));
			    System.out.println(resultat1.getString(2));
			    System.out.println(resultat1.getString(3));
			    System.out.println(resultat1.getString(4));
			    System.out.println(resultat1.getString(5));
			    System.out.println(resultat1.getString(6));
			    System.out.println(resultat1.getString(7));
			    System.out.println(resultat1.getString(8));
			    System.out.println(resultat1.getString(9));
			    System.out.println(resultat1.getString(10));
			    
			    //resultat = resultat+" "+resultat1.getString(1);
			    //Integer ref = 1; //Integer.parseInt(resultat1.getString(1)); // a passer en integer
			    asked = new Client(resultat1.getString(1), resultat1.getString(2), resultat1.getString(3), 
			    		resultat1.getString(4), resultat1.getString(5), resultat1.getString(6)
			    		, resultat1.getString(7), resultat1.getString(8), resultat1.getString(9)
			    		, resultat1.getString(10));
			    resultat.add(asked);
			}
		} catch (ClassNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		//System.out.println(resultat);
		return resultat;
		
	}
	
	public static ArrayList<Produits_panier> lireProduitsPanier () {
		
		ArrayList<Produits_panier> resultat = new ArrayList<Produits_panier>();
		Produits_panier asked;
		
		String url = "jdbc:mysql://localhost:8889/gestion_site";
		String login = "root";
		String passwd = "root";
		java.sql.Connection cn = null;
		
		try {
			Class.forName("com.mysql.jdbc.Driver");
			cn = DriverManager.getConnection(url, login, passwd);
			Statement st1 = (Statement) cn.createStatement();
			String sql = "SELECT * FROM produits_panier;";
			ResultSet resultat1 = (ResultSet) st1.executeQuery(sql);
			while (resultat1.next()) {
			    //System.out.print("Colonne 1 renvoy�e ");
			    System.out.println(resultat1.getString(1));
			    System.out.println(resultat1.getString(2));
			    System.out.println(resultat1.getString(3));
			    System.out.println(resultat1.getString(4));
			    System.out.println(resultat1.getString(5));
			    
			    Double prix_ht = Double.parseDouble(resultat1.getString(4));
			    Double tva = Double.parseDouble(resultat1.getString(5));
			    Double prix_ttc = prix_ht + ((prix_ht * tva) / 100);
			    System.out.println(prix_ttc);
			    String TTC = prix_ttc.toString();
			    
			    System.out.println(resultat1);
			    
			    //resultat = resultat+" "+resultat1.getString(1);
			    //Integer ref = 1; //Integer.parseInt(resultat1.getString(1)); // a passer en integer
			    asked = new Produits_panier(resultat1.getString(1), resultat1.getString(2), Integer.parseInt(resultat1.getString(3)), 
			    		 resultat1.getString(4),  resultat1.getString(5), TTC);
			    resultat.add(asked);
			}
		} catch (ClassNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		//System.out.println(resultat);
		return resultat;
		
	}

public static ArrayList<Panier> lirePanier () {
		
		ArrayList<Panier> resultat = new ArrayList<Panier>();
		Panier asked;
		
		String url = "jdbc:mysql://localhost:8889/gestion_site";
		String login = "root";
		String passwd = "root";
		java.sql.Connection cn = null;
		
		try {
			Class.forName("com.mysql.jdbc.Driver");
			cn = DriverManager.getConnection(url, login, passwd);
			Statement st1 = (Statement) cn.createStatement();
			String sql = "SELECT * FROM panier;";
			ResultSet resultat1 = (ResultSet) st1.executeQuery(sql);
			while (resultat1.next()) {
			    //System.out.print("Colonne 1 renvoy�e ");
			    System.out.println(resultat1.getString(1));
			    System.out.println(resultat1.getString(2));
			    System.out.println(resultat1.getString(3));
			    

			    
			    //resultat = resultat+" "+resultat1.getString(1);
			    //Integer ref = 1; //Integer.parseInt(resultat1.getString(1)); // a passer en integer
			    asked = new Panier(resultat1.getString(1), Double.parseDouble(resultat1.getString(2)), resultat1.getString(3));
			    resultat.add(asked);
			}
		} catch (ClassNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		//System.out.println(resultat);
		return resultat;
		
	}
	
}

