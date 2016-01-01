Imports APIControllers
Imports Models

Public Class Personal
    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        Me.Close()
    End Sub

    Private Sub Personal_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        If (My.Settings.APIKey.Trim() = "") Then
            If (MessageBox.Show("Add your API key first") = DialogResult.OK) Then
                Settings.Show()
            End If
        Else
            Dim account = GetMyInfo()
            lblAccount.Text = account.Name
            DataGridView1.DataSource = account.Characters
        End If

    End Sub

    Private Function GetMyInfo() As Account

        Dim acc_controller = New AccountControllers()
        Dim char_controller = New CharacterController()
        Dim account = acc_controller.GetAccount(My.Settings.APIKey)
        Dim characters = char_controller.GetCharacters(My.Settings.APIKey)

        account.Characters = characters
        Return account
    End Function
End Class