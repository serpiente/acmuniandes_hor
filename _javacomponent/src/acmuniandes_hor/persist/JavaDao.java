package acmuniandes_hor.persist;

import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;

import acmuniandes_hor.entidades.Curso;

public class JavaDao {
	
	public void persistCurso(Curso curso){
		//TODO persistir un curso a una base de datos
		System.out.println(curso.toString());
	}
	
	public void updateCurso(Curso curso){
		System.out.println(curso.toString());
	}
}
