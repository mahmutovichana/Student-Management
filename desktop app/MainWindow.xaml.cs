using System;
using System.Windows;
using MySql.Data.MySqlClient;
using System.Data;

namespace StudentManagement
{
    public partial class MainWindow : Window
    {
        private int trenutniRed = 0;
        private DataTable dataTable;

        public MainWindow()
        {
            InitializeComponent();
            BindDataGrid(); // Pozovite funkciju za punjenje DataGrid-a prilikom otvaranja prozora
        }

        private void BindDataGrid()
        {
            string connectionString = "Server=localhost;Database=crud_baza;Uid=root;Pwd=prekucatcuovo";
            MySqlConnection connection = new MySqlConnection(connectionString);

            try
            {
                connection.Open();
                string query = "SELECT * FROM student";
                MySqlDataAdapter dataAdapter = new MySqlDataAdapter(query, connection);
                dataTable = new DataTable();
                dataAdapter.Fill(dataTable);

                // Provjera ispunjenosti tablice
                if (dataTable.Rows.Count > 0)
                {
                    studentDataGrid.ItemsSource = dataTable.DefaultView;
                    MessageBox.Show("Broj redova: " + dataTable.Rows.Count); // Ispis broja redova
                }
                else
                {
                    MessageBox.Show("Tablica je prazna.");
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message);
            }
            finally
            {
                connection.Close();
            }
        }

        private void RefreshDataGrid()
        {
            string connectionString = "Server=localhost;Database=crud_baza;Uid=root;Pwd=prekucatcuovo";
            MySqlConnection connection = new MySqlConnection(connectionString);

            try
            {
                connection.Open();
                string query = "SELECT * FROM student";
                MySqlDataAdapter dataAdapter = new MySqlDataAdapter(query, connection);
                dataTable.Clear(); // Očisti postojeće podatke u DataTable-u
                dataAdapter.Fill(dataTable);

                // Provjera ispunjenosti tablice
                if (dataTable.Rows.Count > 0)
                {
                    studentDataGrid.ItemsSource = dataTable.DefaultView;
                    MessageBox.Show("Broj redova: " + dataTable.Rows.Count); // Ispis broja redova
                }
                else
                {
                    MessageBox.Show("Tablica je prazna.");
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message);
            }
            finally
            {
                connection.Close();
            }
        }

        private void IzvrsiUpit(string query)
        {
            string connectionString = "Server=localhost;Database=crud_baza;Uid=root;Pwd=prekucatcuovo";
            MySqlConnection connection = new MySqlConnection(connectionString);

            try
            {
                connection.Open();
                MySqlCommand cmd = new MySqlCommand(query, connection);
                MySqlDataReader reader = cmd.ExecuteReader();

                while (reader.Read())
                {
                    idTextBox.Text = reader["ID"].ToString();
                    imeTextBox.Text = reader["Ime"].ToString();
                    prezimeTextBox.Text = reader["Prezime"].ToString();
                    adresaTextBox.Text = reader["Adresa"].ToString();
                    gradTextBox.Text = reader["Grad"].ToString();
                }

                reader.Close();
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message);
            }
            finally
            {
                connection.Close();
            }
        }

        private void Prvi_Click(object sender, RoutedEventArgs e)
        {
            trenutniRed = 1;
            string query = "SELECT * FROM student ORDER BY ID ASC LIMIT 1";
            IzvrsiUpit(query);
        }

        private void Zadnji_Click(object sender, RoutedEventArgs e)
        {
            trenutniRed = dataTable.Rows.Count-1;
            string query = "SELECT * FROM student ORDER BY ID DESC LIMIT 1";
            IzvrsiUpit(query);
        }

        private void Prethodni_Click(object sender, RoutedEventArgs e)
        {
            if (trenutniRed > 0)
            {
                trenutniRed--;
                PrikaziRed(trenutniRed);
            }
        }

        private void Sljedeci_Click(object sender, RoutedEventArgs e)
        {
            if (trenutniRed < dataTable.Rows.Count - 1)
            {
                trenutniRed++;
                PrikaziRed(trenutniRed);
            }
        }

        private void PrikaziRed(int red)
        {
            idTextBox.Text = dataTable.Rows[red]["ID"].ToString();
            imeTextBox.Text = dataTable.Rows[red]["Ime"].ToString();
            prezimeTextBox.Text = dataTable.Rows[red]["Prezime"].ToString();
            adresaTextBox.Text = dataTable.Rows[red]["Adresa"].ToString();
            gradTextBox.Text = dataTable.Rows[red]["Grad"].ToString();
        }

        private void Unos_Click(object sender, RoutedEventArgs e)
        {
            UnosPopup popup = new UnosPopup();
            popup.ShowDialog();
            RefreshDataGrid();
        }

        private void Azuriranje_Click(object sender, RoutedEventArgs e)
        {
            AzuriranjePopup popup = new AzuriranjePopup();
            popup.ShowDialog();
            RefreshDataGrid();
        }

        private void Brisanje_Click(object sender, RoutedEventArgs e)
        {
            BrisanjePopup popup = new BrisanjePopup();
            popup.ShowDialog();
            RefreshDataGrid();
        }
    }
}
