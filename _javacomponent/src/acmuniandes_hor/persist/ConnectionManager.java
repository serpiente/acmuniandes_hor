package acmuniandes_hor.persist;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.Statement;

import javax.swing.JOptionPane;


import com.jcraft.jsch.JSch;
import com.jcraft.jsch.Session;
import com.jcraft.jsch.UIKeyboardInteractive;
import com.jcraft.jsch.UserInfo;

/**
 * Método que maneja la conexión a MYSQL. Provee diferentes métodos para
 * inicializar la conexión.
 * 
 * @author Jorge
 * 
 */
public class ConnectionManager {

	// ------------------------------
	// Constantes
	// ------------------------------

	private final static String SSH_HOST = "crearhorariopr.uniandes.edu.co";
	private final static String SSH_USER = "crearhorario";
	private final static String SSH_PASSWORD = "w3amJHcq";
	private final static int FOWARD_PORT = 22;
	private final static String REMOTE_HOST = "apolo.uniandes.edu.co";
	private final static int REMOTE_PORT = 3308;
	private final static String REMOTE_INSTANCE = "dbcrearhorario";
	private final static String REMOTE_USER = "usdbcrearhorario";
	private final static String REMOTE_PASSWORD = "4CbWAHKz";

	// ---------------------------
	// Atributos
	// ---------------------------

	/**
	 * Conexión MySQL.
	 */

	private Connection conMySQL;

	/**
	 * Sesion para el manejo del tunel
	 */

	private Session session;
	/**
	 * Proveedor para el manejo de SSH por java
	 */

	private JSch jsch;

	// ---------------------------
	// Métodos
	// -----------------------------

	/**
	 * Constructor de la clase. Por defecto esta construyendo la conexión
	 * creando un tunel SSH.
	 */
	public ConnectionManager() {
		conMySQL = obtenerConexionTunelSSH();
	}

	/**
	 * Método que retorna una conexión a mysql.
	 */

	public Connection getConnection() {
		return conMySQL;
	}

	/**
	 * 
	 * Método que cierra las conexiones a mysql y el tunel ssh. El método asume
	 * que ya se han cerrado todos los statements y los resultsets.
	 * 
	 */

	public void closeConnection() {
		try {
			// Se presento un error al cerrar la conexión.
			conMySQL.close();
			//Si se obtuvo la conexión por medio del tunel..
			if(session!=null)
			session.disconnect();
		} catch (Exception e) {
			e.printStackTrace();
		}

	}

	/**
	 * Constructor de la conexión a partir de un tunel SSH. Construye el tunel y
	 * hace un foward de todos los paquetes que se envien a
	 * localhost:FOWARD_PORT a REMOTE_HOST:REMOTE_PORT
	 */

	private Connection obtenerConexionTunelSSH() {
		try {
			jsch = new JSch();
			session = jsch.getSession(SSH_USER, SSH_HOST, 22);
			UserInfo ui = new MyUserInfo();
			session.setUserInfo(ui);
			session.connect();
			int assigned_port = session.setPortForwardingL(FOWARD_PORT,
					REMOTE_HOST, REMOTE_PORT);
			System.out.println("localhost:" + assigned_port + " -> "
					+ REMOTE_HOST + ":" + REMOTE_PORT);

			Connection con = null;

			String url = "jdbc:mysql://localhost:" + assigned_port + "/"
					+ REMOTE_INSTANCE;

			con = DriverManager
					.getConnection(url, REMOTE_USER, REMOTE_PASSWORD);
			System.out.println("La conexión se ha creado de forma adecuada..");
			return con;
		} catch (Exception e) {
			e.printStackTrace();
			System.out.println("Error al crear la conexión a través del tunel");
			return null;
		}

	}

	/**
	 * CLASE DE SOPORTE PARA CREAR EL TUNEL.
	 * 
	 * @author Jorge
	 */

	public static class MyUserInfo implements UserInfo, UIKeyboardInteractive {
		public String getPassword() {
			return passwd;
		}

		public boolean promptYesNo(String str) {
			return true;
		}

		String passwd;

		public String getPassphrase() {
			return null;
		}

		public boolean promptPassphrase(String message) {
			return true;
		}

		public boolean promptPassword(String message) {
			passwd = SSH_PASSWORD;
			return true;
		}

		public void showMessage(String message) {
			JOptionPane.showMessageDialog(null, message);
		}

		public String[] promptKeyboardInteractive(String destination,
				String name, String instruction, String[] prompt, boolean[] echo) {
			return null;
		}
	}

	public static void main(String[] args) {
		ConnectionManager cm = new ConnectionManager();
		cm.closeConnection();

	}

}
