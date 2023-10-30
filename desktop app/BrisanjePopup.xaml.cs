using System;
using System.Windows;
using MySql.Data.MySqlClient;
using System.Data;
using System.Collections.Generic;

namespace StudentManagement
{
    public partial class BrisanjePopup : Window
    {
        private DataTable dataTable;

        public BrisanjePopup()
        {
            InitializeComponent();
            FillComboBox();
        }

        private void FillComboBox()
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

                if (dataTable.Rows.Count > 0)
                {
                    // Promijenite sljedeći dio koda kako biste postavili pravi izvor podataka
                    List<string> osobe = new List<string>();

                    foreach (DataRow row in dataTable.Rows)
                    {
                        string ime = row["Ime"].ToString();
                        string prezime = row["Prezime"].ToString();
                        osobe.Add(ime + " " + prezime);
                    }

                    osobaComboBox.ItemsSource = osobe;
                }
                else
                {
                    MessageBox.Show("Nema dostupnih podataka.");
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

        private void Delete_Click(object sender, RoutedEventArgs e)
        {
            if (osobaComboBox.SelectedItem == null)
            {
                MessageBox.Show("Molimo odaberite osobu.");
            }
            else
            {
                string connectionString = "Server=localhost;Database=crud_baza;Uid=root;Pwd=prekucatcuovo";
                MySqlConnection connection = new MySqlConnection(connectionString);

                try
                {
                    connection.Open();
                    string selectedPerson = osobaComboBox.SelectedItem.ToString();
                    string[] parts = selectedPerson.Split(' ');
                    string selectedFirstName = parts[0];
                    string selectedLastName = parts[1];

                    string deleteQuery = "DELETE FROM student WHERE Ime = @Ime AND Prezime = @Prezime";
                    MySqlCommand deleteCommand = new MySqlCommand(deleteQuery, connection);
                    deleteCommand.Parameters.AddWithValue("@Ime", selectedFirstName);
                    deleteCommand.Parameters.AddWithValue("@Prezime", selectedLastName);
                    deleteCommand.ExecuteNonQuery();

                    MessageBox.Show("Podaci uspješno obrisani.");
                    this.Close();
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
        }
    }
}
