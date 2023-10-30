using System;
using System.Windows;
using MySql.Data.MySqlClient;
using System.Data;

namespace StudentManagement
{
    public partial class AzuriranjePopup : Window
    {
        private DataTable dataTable;

        public AzuriranjePopup()
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
                    osobaComboBox.ItemsSource = dataTable.DefaultView;
                    osobaComboBox.DisplayMemberPath = "Ime"; // Prikazuje samo imena u ComboBoxu
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

        private void OsobaComboBox_SelectionChanged(object sender, System.Windows.Controls.SelectionChangedEventArgs e)
        {
            if (osobaComboBox.SelectedItem != null)
            {
                DataRowView dataRow = (DataRowView)osobaComboBox.SelectedItem;
                idTextBox.Text = dataRow["ID"].ToString();
                imeTextBox.Text = dataRow["Ime"].ToString();
                prezimeTextBox.Text = dataRow["Prezime"].ToString();
                adresaTextBox.Text = dataRow["Adresa"].ToString();
                gradTextBox.Text = dataRow["Grad"].ToString();
            }
        }

        private void Save_Click(object sender, RoutedEventArgs e)
        {
            if (osobaComboBox.SelectedItem == null)
            {
                MessageBox.Show("Molimo odaberite osobu.");
            }
            else if (string.IsNullOrEmpty(idTextBox.Text) || string.IsNullOrEmpty(imeTextBox.Text) || string.IsNullOrEmpty(prezimeTextBox.Text) || string.IsNullOrEmpty(adresaTextBox.Text) || string.IsNullOrEmpty(gradTextBox.Text))
            {
                MessageBox.Show("Molimo popunite sva polja.");
            }
            else
            {
                string connectionString = "Server=localhost;Database=crud_baza;Uid=root;Pwd=prekucatcuovo";
                MySqlConnection connection = new MySqlConnection(connectionString);

                try
                {
                    connection.Open();
                    string updateQuery = "UPDATE student SET Ime = @Ime, Prezime = @Prezime, Adresa = @Adresa, Grad = @Grad WHERE ID = @ID";
                    MySqlCommand updateCommand = new MySqlCommand(updateQuery, connection);
                    updateCommand.Parameters.AddWithValue("@ID", idTextBox.Text);
                    updateCommand.Parameters.AddWithValue("@Ime", imeTextBox.Text);
                    updateCommand.Parameters.AddWithValue("@Prezime", prezimeTextBox.Text);
                    updateCommand.Parameters.AddWithValue("@Adresa", adresaTextBox.Text);
                    updateCommand.Parameters.AddWithValue("@Grad", gradTextBox.Text);
                    updateCommand.ExecuteNonQuery();

                    MessageBox.Show("Podaci uspješno ažurirani.");
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
