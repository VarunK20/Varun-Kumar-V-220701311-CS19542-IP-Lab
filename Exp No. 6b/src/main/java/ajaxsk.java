import java.io.IOException;
import java.io.PrintWriter;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

@WebServlet("/StudentServlet")
public class ajaxsk extends HttpServlet {
    private static final long serialVersionUID = 1L;

    // Array of student names
    String[] students = { "Alice", "Bob", "Charlie", "David", "Eva", "Frank", "Grace", "Hannah", "Isaac", "Jack" };

    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        response.setContentType("text/html");

        String query = request.getParameter("query");
        PrintWriter out = response.getWriter();

        // If the query is not null and not empty, search for matching names
        if (query != null && !query.isEmpty()) {
            query = query.toLowerCase();  // Convert input to lowercase for case-insensitive matching

            // Loop through the array and find names that start with the input query
            for (String student : students) {
                if (student.toLowerCase().startsWith(query)) {
                    out.println("<p>" + student + "</p>");  // Display matching names in separate paragraphs
                }
            }
        }

        out.close();
    }
}
