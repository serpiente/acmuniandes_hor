package acmuniandes_hor.persist;

import java.sql.Connection;

import acmuniandes_hor.entidades.Curso;

/**
 * Clase que persiste las entidades de Curso dentro de la base de datos.
 * @author Jorge
 */
public class JavaDao {
	
	//--------------
	// Atributos
	//-------------
	
	/**
	 * Conexi�n a la base de datos
	 */
	
	private Connection conn;
	
	/**
	 * Fabrica de las conexiones
	 */
	private ConnectionManager cm;
	
	
	//-----------------
	// M�todos
	//-----------------
	
	/**
	 * Constructor de la clase 
	 */
	public JavaDao()
	{
		cm = new ConnectionManager();
		conn = cm.getConnection();
	}
	
	/**
	 * M�todo que cierra la conexi�n.
	 */
	
	public void closeConnection()
	{
		cm.closeConnection();
	}
	
	
	/**
	 * M�todo que persiste un curso.
	 * <pre><b>pre:</b> Se asume que el curso tiene asignado sus valores de forma valida.
	 * @param curso
	 */
	public void persistCurso(Curso curso){
		String query = "INSERT INTO CURSOS VALUES (" + curso.getCrn() +",'" + curso.getCodigo() + 
		"','" + curso.getTitulo() + "'," + curso.getSeccion() + "," + curso.getCreditos() + "," +
		curso.getDisponibles() + "," + curso.getInscritos() + "," + curso.getCapacidad() + ",'" +
		curso.getTipo() + "','" + curso.getDepartamento() + "','" + curso.getMagistral() + "')";
		
		if(curso.getMagistral()!=null)		
		System.out.println(query);
	}
	
	public void updateCurso(Curso curso){
		System.out.println(curso.toString());
	}
}
