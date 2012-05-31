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
	 * Conexión a la base de datos
	 */
	
	private Connection conn;
	
	/**
	 * Fabrica de las conexiones
	 */
	private ConnectionManager cm;
	
	
	//-----------------
	// Métodos
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
	 * Método que cierra la conexión.
	 */
	
	public void closeConnection()
	{
		cm.closeConnection();
	}
	
	
	/**
	 * Método que persiste un curso.
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
