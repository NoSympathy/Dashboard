Imports APICore
Imports System.Net
Imports Newtonsoft.Json
Imports System.Web.UI.WebControls

Public Class FormList
    
    Private Sub FormList_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        'Dim controller = New WorldController()
        Dim client = New WebClient()
        Dim endPoints = New Uri("https://api.guildwars2.com/v2/worlds?ids=all")

        Dim jsonString = client.DownloadString(endPoints)

        Dim worldList = JsonConvert.DeserializeObject(Of List(Of Worlds))(jsonString)

        For Each world As Worlds In worldList
            ListBox1.Items.Add(world.Name)
        Next

        'Dim items = New List(Of ListItem)
        'For Each world As Worlds In worldList
        '    Dim et = New ListItem()
        '    et.Text = world.Name
        '    et.Value = world.Id
        '    items.Add(et)
        'Next
        'ListBox1.DataSource = items
    End Sub
End Class

Public Class Worlds
    Public Id As Integer
    Public Name As String
    Public Population As String
End Class

'Public Class Worlds
'    Public _Id As Integer
'    Public _Name As String
'    Public _Population As String

'    Public Property Id() As Integer
'        Get
'            Return _Id
'        End Get
'        Set(value As Integer)
'            Me._Id = value
'        End Set
'    End Property

'    Public Property Name() As String
'        Get
'            Return _Name
'        End Get
'        Set(value As String)
'            Me._Name = value
'        End Set
'    End Property

'    Public Property Population() As String
'        Get
'            Return _Population
'        End Get
'        Set(value As String)
'            Me._Population = value
'        End Set
'    End Property

'End Class