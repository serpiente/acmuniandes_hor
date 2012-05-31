package acmuniandes_hor.persist;


import java.sql.Connection;
import java.sql.Statement;
import java.text.SimpleDateFormat;
import java.util.ArrayList;

import acmuniandes_hor.entidades.Curso;
import acmuniandes_hor.entidades.Ocurrencia;

/**
 * Clase que persiste las entidades de Curso dentro de la base de datos.
 * 
 * @author Jorge
 */
public class JavaDao {

	// --------------
	// Atributos
	// -------------

	/**
	 * Conexión a la base de datos
	 */

	private Connection conn;

	/**
	 * Fabrica de las conexiones
	 */
	private ConnectionManager cm;

	// -----------------
	// Métodos
	// -----------------

	/**
	 * Constructor de la clase
	 */
	public JavaDao() {
		cm = new ConnectionManager();
		conn = cm.getConnection();
	}

	/**
	 * Método que cierra la conexión.
	 */

	public void closeConnection() {
		cm.closeConnection();
	}

	/**
	 * Método que persiste un curso.
	 * 
	 * <pre>
	 * &lt;b&gt;pre:&lt;/b&gt; Se asume que el curso tiene asignado sus valores de forma valida.
	 * &#064;param curso
	 * 
	 */
	public void persistCurso(Curso curso) {
		if (curso.getOcurrencias() != null) {
			String query = "";
			try {
				Statement st = conn.createStatement();
				query = "";
				if(curso.getMagistral()!=null)
				{
				query = "INSERT INTO CURSOS VALUES (" + curso.getCrn()
						+ ",'" + curso.getCodigo() + "','" + curso.getTitulo()
						+ "'," + curso.getSeccion() + "," + curso.getCreditos()
						+ "," + curso.getDisponibles() + ","
						+ curso.getInscritos() + "," + curso.getCapacidad()
						+ ",'" + curso.getTipo() + "','"
						+ curso.getDepartamento() + "','"
						+ curso.getMagistral() + "')";
				}else{
					query = "INSERT INTO CURSOS(CRN, CODIGO, TITLE, SECCION, CREDITOS,CUPOS_DISPONIBLES, INSCRITOS,CAPACIDAD_TOTAL,TIPO,DEPARTAMENTO) VALUES (" + curso.getCrn()
					+ ",'" + curso.getCodigo() + "','" + curso.getTitulo()
					+ "'," + curso.getSeccion() + "," + curso.getCreditos()
					+ "," + curso.getDisponibles() + ","
					+ curso.getInscritos() + "," + curso.getCapacidad()
					+ ",'" + curso.getTipo() + "','"
					+ curso.getDepartamento() + "')";
				}
				st.execute(query);
				SimpleDateFormat sdf1 = new SimpleDateFormat("dd-MM-yy");
				SimpleDateFormat sdf2 = new SimpleDateFormat("yyyy-MM-dd");
				ArrayList<Ocurrencia> arreglo = curso.getOcurrencias();
				for (Ocurrencia ocurrencia : arreglo) {
					query = "INSERT INTO OCURRENCIAS (HORA_INICIO,HORA_FIN,DIA, SALON, FECHA_INICIO, FECHA_FIN, CRN_CURSO)"
							+ "VALUES ("
							+ ocurrencia.getHoraInicio()
							+ ","
							+ ocurrencia.getHoraFin()
							+ ",'"
							+ ocurrencia.getDia()
							+ "','"
							+ ocurrencia.getSalon().substring(1,
									ocurrencia.getSalon().length())
							+ "','"
							+ sdf2.format(sdf1.parse(arreglarFecha(ocurrencia.getFechaInicial())))
							+ "','"
							+ sdf2.format(sdf1.parse(arreglarFecha(ocurrencia.getFechaFinal())))
							+ "',"
							+ curso.getCrn()
							+ ")";

					st.execute(query);

				}

				ArrayList<String> profesores = curso.getProfesores();
				if (profesores != null) {
					for (String string : profesores) {
						query = "INSERT INTO PROFESORES (NOMBRE) VALUES('"
								+ string + "')";
						try{
						st.execute(query);
						}catch(Exception e)
						{
							//Puede pasar..
						}
						query = "INSERT INTO PROFESORES_CURSOS VALUES('"
								+ string + "'," + curso.getCrn() + ")";
						st.execute(query);

					}
				}
				
				st.close();

			} catch (Exception e) {
				// Oh Uh D:
				System.out.println(query);
				e.printStackTrace();
			}
		}
	}

	public void updateCurso(Curso curso) {
		System.out.println("DONE!");
		// System.out.println(curso.toString());
	}
	
	
	/**
	 * Método que ayuda a la conversión de fechas de español a numero.
	 * @param fecha en representacion dd - (MM,esp) - yyyy
	 * return fecha en representacion dd - mm(numero) - yyy
	 */
	
	private String arreglarFecha(String param)
	{
		String[] partes = param.split("-");
		String dia = partes[0];
		String mes = partes[1];
		String anio = partes[2];
		
		if(mes.equals("ENE"))
		{
			mes = "01";
		}else if(mes.equals("FEB"))
		{
			mes = "02";
		}else if(mes.equals("MAR"))
		{
			mes = "03";
		}else if(mes.equals("ABR"))
		{
			mes  = "04";
		}else if(mes.equals("MAY"))
			mes = "05";
		else if(mes.equals("JUN"))
			mes = "06";
		else if(mes.equals("JUL"))
			mes = "07";
		else if(mes.equals("AGO"))
			mes = "08";
		else if(mes.equals("SEP"))
			mes = "09";
		else if(mes.equals("OCT"))
			mes = "10";
		else if(mes.equals("NOV"))
			mes = "11";
		else
			mes = "12";	
		
		return dia + "-" + mes + "-" + anio;
	}
}
